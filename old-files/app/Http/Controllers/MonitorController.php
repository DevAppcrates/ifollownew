<?php

namespace App\Http\Controllers;

use App\ForgotPassword;
use App\GroupMembers;
use App\Hours;
use App\Http\Controllers\Controller;
use App\Invitees;
use App\Monitors;
use App\NotificationGroup;
use App\Notifications;
use App\Rules\PublishDateValidate;
use App\Schedule;
use App\Templates;
use App\UserDeletedNotification;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mail;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class MonitorController extends Controller {
	//
	public function monitor_login(Request $request) {
		$email = $request->input('email');
		$password = $request->input('password');
		$password = md5($password);
		if ($user = Monitors::with('organizations.organization.time_zone', 'phone_code')->where('monitor_email', $email)->where('password', $password)->first()) {
			if ($user->status != 'enabled') {
				echo 'Your Account Has been Disabled By <b>Administration</b>. For further details contact with Authorities';
			} else {

				$data = $user->toArray();
				Session::push('monitor_admin', $data);

				echo 'login successful';
			}
		} else {
			echo 'Invalid credentials';
		}
	}

	public function monitor_forget(Request $request) {
		$exists = Monitors::where('monitor_email', $request->email)->first();
		if (!$exists) {
			die("email doesn't exists OR invalid email given");

		}

		$monitor = Monitors::where('monitor_email', $request->email)->first();
		$token = uniqid();
		ForgotPassword::where('email', $monitor->monitor_email)->delete();
		$forgot = new ForgotPassword;
		$forgot->email = $monitor->monitor_email;
		$forgot->token = $token;
		$forgot->save();

		Mail::send([], [], function ($message) use ($monitor, $token) {

			$body = "<h1>Hello " . $monitor->monitor_name . "! </h1>";
			$body .= "<p>
                       We Have received your request to reset the password for your iFollow-Alert Monitor-Hub account. If you did-not request this change, please contact your iFollow-Alert rep immediately. Otherwise: Please click the following link to securely reset your password.
                       </p>";
			$body .= "<strong>click here:</strong>" . url('monitor-hub/password/change') . '/' . $token;
			$body .= "<br><strong>Do not reply to this email. It has been automatically generated.<strong>";

			$message->to($monitor->monitor_email)->subject('iFollow-Alert | Forget Password Verification')->setBody($body, 'text/html');
		});
		$request->session()->flash('success', 'password Verification Link has been sent to your email address kindly. check it out & change the password safely...');
		return response()->json(['response' => 'success']);

	}
	public function change_password_monitor(Request $request) {

		$requested_by = ForgotPassword::where('token', $request->token)->first();
		$monitor = Monitors::where('monitor_email', $requested_by->email)->first();
		$monitor->password = md5($request->input('password'));

		$save = $monitor->save();
		if ($save) {
			ForgotPassword::where('email', $monitor->email)->delete();
			$request->session()->flash('success', 'Password Changed Successfully...');
			return response()->json(['response' => 'success']);
		} else {
			$request->session()->flash('error', 'there is an issue while changing password try with new request');
			return response()->json(['response' => 'unsuccess']);
		}

	}
	public function password_change_view(Request $request, $token) {
		$requested_by = ForgotPassword::where('token', $token)->exists();
		if (!$requested_by) {
			$request->session()->flash('error', 'Request Timeout! verification link has been expired make a new request');
			return redirect('/monitor-hub');
		}
		return view('monitor.password_change', ['token' => $token]);
	}

	public function notifications() {
		if (Session::has('monitor_admin')) {
			$user = Session::get('monitor_admin');
			$organization_id = $user[0]['organizations'][0]['organization_id'];
			$notifications = Notifications::where('organization_id', $organization_id)->where('is_archive', 0)->orderby('id', 'desc')->get();
		}
		return view('monitor.notifications.notifications', ["notifications" => $notifications]);
	}

	public function notification_templates() {
		$templates = Templates::where('organization_id', session('monitor_admin.0.organizations.0.organization_id'))->orderBy('id', 'desc')->get();
		return view('monitor.notifications.notification-templates', compact('templates'));
	}

	public function archive_notifications() {
		if (Session::has('monitor_admin')) {
			$user = Session::get('monitor_admin');
			$organization_id = $user[0]['organizations'][0]['organization_id'];
			$notifications = Notifications::where('organization_id', $organization_id)->where('is_archive', 1)->get();
		}
		return view('monitor.notifications.notifications', ["notifications" => $notifications]);
	}

	public function add_template(Request $request) {

		$template = new Templates;
		$template->organization_id = session('monitor_admin.0.organizations.0.organization_id');
		$template->title = $request->title;
		$template->notification = $request->notification;
		$template->save();
		echo 'Created successfully';
	}

	public function edit_template(Request $request) {
		$template = Templates::find($request->template_id);
		$template->title = $request->title;
		$template->notification = $request->notification;
		$template->save();
		echo 'Updated successfully';
	}
	public function delete_template(Request $request) {
		$template = Templates::find($request->id)->delete();
		echo 'Deleted successfully';
	}
	public function getTemplate(Request $request) {
		$template = Templates::find($request->template_id);
		return response()->json(['response' => $template]);
	}

	public function edit_notification(Request $request) {
		$timestamp = '';
		if ($request->date && $request->time && $request->am_pm) {
			$time = Hours::where('id', $request->time)->first();
			$timestamp = $request->date . ' ' . $time->hour . ' ' . $request->am_pm;

		}

		$request->validate(['groups' => 'required', 'time' => ['required_if:schedule,1', new PublishDateValidate($timestamp, session('monitor_admin.0.organizations.0.time_zone.timezone_code'), $request->schedule)], 'date' => 'required_if:schedule,1', 'am_pm' => 'required_if:schedule,1'], ['time.required_if' => 'time is required to schedule the Mass Notification properly', 'date.required_if' => 'date is required to schedule the Mass Notification properly', 'am_pm.required_if' => 'AM/PM must be set']);
		if (Session::has('monitor_admin')) {
			$user = Session::get('monitor_admin');
			$organization_id = $user[0]['organizations'][0]['organization_id'];
			$admin_id = $user[0]['id'];
			$organization_name = $user[0]['organizations'][0]['organization_name'];
			$name = $user[0]['name'];
		}
		config(['app.timezone' => session('monitor_admin.0.organizations.0.time_zone.timezone_code')]);
		ini_set('date.timezone', config('app.timezone'));
		// date_default_timezone_set(config('app.timezone'));

		$notification = Notifications::find($request->id);
		$notification->organization_id = $organization_id;
		$notification->admin_id = $admin_id;
		$notification->name = $name;
		// $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;"\<\>\?\\\]/';

		$notification->title = $request->title;
		$notification->notification = $request->notification;
		$notification->priority = '[ ' . $request->priority . ' Alert ]';
		if ($request->type == 2) {
			$type = 3;
			$notification->path = $request->audio_src;
		} else {
			// $notification->type = 0;
			// $notification->path = NULL;
		}
		if ($request->file) {

			if (file_exists(base_path('public') . '/images/notifications/' . basename($notification->path))) {
				unlink(base_path('public') . '/images/notifications/' . basename($notification->path));
			}
			$destinationPath = 'public/images/notifications/';

			$extension = $request->file->extension();
			$image = uniqid() . '.' . $extension;
			$request->file->move($destinationPath, $image);
			$image_path = url('/') . '/' . $destinationPath . $image;
			$notification->path = $image_path;
			$check_image_path = str_replace('https://', 'http://', $image_path);
			if (strstr($request->file->getClientMimeType(), "image")) {
				$type = 1;
			} else {
				$type = 2;
			}

			$notification->type = $type;

		}
		if ($request->schedule == 0) {
			$notification->status = 1;
			$notification->published_at = NULL;

		} else {
			if ($request->date && $request->time && $request->am_pm) {
				$time = Hours::where('id', $request->time)->first();
				$date = $request->date . ' ' . $time->hour . ' ' . $request->am_pm;
				$notification->status = 0;
				// (date('Y-m-d H:i:s',strtotime($date);
				$notification->published_at = date('Y-m-d H:i:s', strtotime($date));

			}

		}
		$notification->save();
		if ($request->has('groups')) {
			$groups = $request->groups;
			NotificationGroup::where('notification_id', $notification->id)->delete();
			foreach ($groups as $key => $value) {
				NotificationGroup::create(['notification_id' => $notification->id, 'group_id' => $value]);
			}
			$user_ids = GroupMembers::selectRaw('distinct user_id')->whereIn('group_id', $groups)->get()->pluck('user_id');
			$users = Users::whereIn('user_id', $user_ids)->get();
			$invitees_users = Invitees::whereIn('id', $user_ids)->get();
			$firebase_tokens = $users->where('device_token', '!=', NULL)->where('is_push', 1)->pluck('device_token')->all();
		}
		if ($request->schedule == 0) {
			if (count($users)) {

				//Mail

				$accountSid = 'AC7966ed796f64aa074e05e7db1d982a36';
				$authToken = '002a6ef044af01d69cb979eb4107b9fe';
				$twilioNumber = "+14359195249";
				$client = new Client($accountSid, $authToken);

				foreach ($users as $user) {
					try {
						Mail::send([], [], function ($message) use ($user, $notification, $organization_name) {

							$body = $notification->priority . '<br>';
							$body .= '<strong>' . $notification->title . '</strong><br>';
							if ($notification->notification) {
								$body .= '<br>' . $notification->notification;
							}
							if ($notification->is_report) {
								$url = url('/') . '/notification/' . $user->user_id . '/' . $notification->id . '/2';
								$url = $this->fetchTinyUrl($url);
								$body .= '<br>' . '<a href="' . $url . '">Click here</a>';
								$body .= "to confirm receipt of this message.";

							}
							$message->from('alert@ifollow.com', $organization_name);

							$message->to($user->email)->subject($notification->priority . ' ' . $notification->title . ' - ' . session('monitor_admin.0.organizations.0.organization_name'))->setBody($body, 'text/html');

						});

					} catch (\Exception $e) {

					}

					$body = $notification->priority . ' ' . $request->title . ' - ' . session('monitor_admin.0.organizations.0.organization_name') . "\n\n" . $notification->title . "\n\n";
					if ($notification->notification) {
						$body .= $notification->notification . "\n\n";

					}
					if ($notification->is_report) {
						$url = url('/') . '/notification/' . $user->user_id . '/' . $notification->id . '/1';
						$url = $this->fetchTinyUrl($url);
						$body .= "Click Here to confirm receipt of this message." . "\n\n";
						$body .= $url;
					}

					$phone_number = $user->country_code . '' . $user->phone_number;
					try {
						$client->messages->create(
							'' . $phone_number,
							[
								"body" => $body,
								"from" => $twilioNumber,
							]
						);
					} catch (TwilioException $e) {
						// echo($e->getMessage());
					}
				}

				//Notification
				$fields = array(
					'notification' => array(
						'id' => $notification->id,
						'title' => $notification->priority . ' ' . "\n\n" . $request->title,
						'text' => $request->notification,
						'organization_id' => $notification->organization_id,
						'type' => $notification->type,
						'path' => $notification->path,
						'priority' => $notification->priority,
						'created_at' => $notification->created_at,
						'sound' => 'default',
					),
					'data' => array(
						'id' => $notification->id,
						'title' => $notification->priority . ' ' . "\n\n" . $request->title,
						'text' => $request->notification,
						'organization_id' => $notification->organization_id,
						'type' => $notification->type,
						'priority' => $notification->priority,
						'path' => $notification->path,
						'created_at' => $notification->created_at,
						'data' => '',
						'sound' => 'default',
					),
					// 'content_available' => true,
					'priority' => 'high',
					'registration_ids' => $firebase_tokens,
				);
				$url = 'https://fcm.googleapis.com/fcm/send';

				$headers = array(
					'Authorization: key=' . 'AIzaSyACGe1bjH9NA51ktR3yV5Lit1bIspdc9nU',
					'Content-Type: application/json',
				);
				// Open connection
				$ch = curl_init();
				// Set the url, number of POST vars, POST data
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
				$result = curl_exec($ch);
			}

			if (count($invitees_users)) {

				$accountSid = 'AC7966ed796f64aa074e05e7db1d982a36';
				$authToken = '002a6ef044af01d69cb979eb4107b9fe';
				$twilioNumber = "+14359195249";
				$client = new Client($accountSid, $authToken);

				foreach ($invitees_users as $user) {
					try {
						Mail::send([], [], function ($message) use ($user, $notification, $organization_name) {

							$body = $notification->priority . '<br>';
							$body .= '<strong>' . $notification->title . '</strong><br>';
							if ($notification->notification) {
								$body .= '<br>' . $notification->notification;
							}
							if ($notification->is_report) {
								$url = url('/') . '/notification/' . $user->id . '/' . $notification->id . '/2';
								$url = $this->fetchTinyUrl($url);
								$body .= '<br>' . '<a href="' . $url . '">Click here</a>';
								$body .= "to confirm receipt of this message.";

							}
							$message->from('alert@ifollow.com', $organization_name);

							$message->to($user->email)->subject($notification->priority . ' ' . $notification->title . ' - ' . session('monitor_admin.0.organizations.0.organization_name'))->setBody($body, 'text/html');

						});

					} catch (\Exception $e) {

					}

					$body = $notification->priority . ' ' . $request->title . ' - ' . session('monitor_admin.0.organizations.0.organization_name') . "\n\n" . $notification->title . "\n\n";
					if ($notification->notification) {
						$body .= $notification->notification . "\n\n";

					}
					if ($notification->is_report) {
						$url = url('/') . '/notification/' . $user->id . '/' . $notification->id . '/1';
						$url = $this->fetchTinyUrl($url);
						$body .= "Click Here to confirm receipt of this message." . "\n\n";
						$body .= $url;
					}

					$phone_number = $user->phone;
					try {
						$client->messages->create(
							'' . $phone_number,
							[
								"body" => $body,
								"from" => $twilioNumber,
							]
						);
					} catch (TwilioException $e) {
						// echo($e->getMessage());
					}
				}
			}
		}
	}

	public function delete_notification(Request $request) {
		NotificationGroup::where('notification_id', $request->notification_id)->delete();
		UserDeletedNotification::where('notification_id', $request->notification_id)->delete();
		$notification = Notifications::find($request->notification_id)->delete();

	}

	public function notification_note(Request $request) {
		$id = $request->input('note_id');
		$notes = $request->input('notes');
		$notification = Notifications::where('id', $id)->first();
		$notification->notes = str_replace("'", "", $notes);
		$notification->save();
	}

	public function add_archive(Request $request) {
		$notify = Notifications::find($request->notification_id);
		$notify->is_archive = true;
		$save = $notify->save();
		if ($save) {
			return response()->json(['response' => 'success']);
		} else {

			return response()->json(['response' => 'unsuccess']);
		}
	}

	public function notification_history($id) {
		$notification_detail = Notifications::with(['sent_by', 'groups.members'])->withCount(['groups'])->findOrFail($id);
		$groups = NotificationGroup::where('notification_id', $id)->pluck('group_id')->all();
		$user_ids = GroupMembers::selectRaw('distinct user_id')->whereIn('group_id', $groups)->whereRaw('group_members.created_at <= (SELECT created_at FROM notifications where notifications.id = ?)', [$id])->get()->pluck('user_id');
		$inviteesCount = Invitees::where('organization_id', session('contact_center_admin.0.organization_id'))->count();
		return view('monitor.notifications.notification-detail', ['notification_detail' => $notification_detail, 'user_ids' => $user_ids, 'inviteesCount' => $inviteesCount]);
	}

	// public function logout(Request $request) {
	// 	$request->session()->forget('monitor_admin');
	// }

	public function logout() {
		Session::flush('monitor_admin');
	}

	public function edit_profile(Request $request) {
		$id = $request->input('id');
		$name = $request->input('name');
		// $user_name = $request->input('user_name');
		$phone = $request->input('phone');
		$address = $request->input('address');
		$additional_detail = $request->input('additional_detail');

		$monitor = Monitors::where('monitor_id', $id)->first();
		// $phone_codes = Countries::where('id', $request->phone_code)->first(['phone_code']);
		$monitor->monitor_name = $name;
		$monitor->phone_number = $phone;
		$monitor->country_id = $request->phone_code;
		$monitor->address = $address;

		$save = $monitor->save();
		if ($save) {

			$user = Monitors::with('organizations.organization.time_zone', 'phone_code')->where('monitor_id', $id)->first();
			$user = $user->toArray();
			$data[] = $user;

			$request->session()->put('monitor_admin', $data);
			echo 'success';
		} else {
			echo 'An error occurred during updating profile ,please try again';
		}
	}

}
