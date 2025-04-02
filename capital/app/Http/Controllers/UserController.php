<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use App\Models\User;
use App\Models\EmailTemplate;

use Illuminate\Support\Facades\Mail;

use App\Mail\SendMailable;

class UserController extends Controller
{
    private function generate_password(){
    	// password Generate
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$length = 10;
    	$randomString = '';
    	for($i = 0; $i < $length; $i ++) {
    		$randomString .= $characters [rand ( 0, strlen ( $characters ) - 1 )];
    	}
    	return $randomString;
    }

    public function forgotPassword(Request $request) {

        $email = $request->get('email');
        

        $user = User::where('email', '=', $email)
                        ->where('deleted', '=', 0)
                        ->where('active', '=', 1)
                        ->first();

        if ($user) {

            $password = $this->generate_password();

            $user->remember_password = str_replace('/','', Hash::make($password));
            
            $user->save();           

            $template = EmailTemplate::where('static_email_heading', '=', 'FORGOT_PASSWORD')->first();

            $src = ['[user_name]', '[site_name]', '[link]'];

            $link = sprintf("https://admin.capital-office.co.uk/reset-password/%s", $user->remember_password);

            $replace = [sprintf("%s %s", $user->first_name, $user->last_name), 'CAPITAL OFFICE LTD', $link];

            $content = str_replace($src, $replace, $template->template);

            $mail = new SendMailable($content);

            $mail->to_email = $email;
            $mail->to_name = sprintf("%s %s", $user->first_name, $user->last_name);
            $mail->subject = $template->subject;
            $mail->mail = $email;

            $mail->process_name = 'FORGOT PASSWORD';

            Mail::to($mail->mail)->send($mail);

            //dispatch(new sendMailJob($mail))->delay(Carbon::now()->addSeconds(5));    


        } else {

            $client = Client::where('email', '=', $email)
                            ->where('deleted', '=', 0)
                            ->where('active', '=', 1)
                            ->first();

            if ($client) {

                $password = $this->generate_password();

                $client->remember_password = str_replace('/', '', Hash::make($password));
                
                $client->save();           

                $template = EmailTemplate::where('static_email_heading', '=', 'FORGOT_PASSWORD')->first();

                $src = ['[user_name]', '[site_name]', '[link]','[site_address]'];

                $link = sprintf("https://admin.capital-office.co.uk/reset-password/%s", $client->remember_password);

                $replace = [sprintf("%s %s", $client->first_name, $client->last_name), 'CAPITAL OFFICE LTD', $link, 'https://admin.capital-office.co.uk/'];

                $content = str_replace($src, $replace, $template->template);

                $mail = new SendMailable($content);

                $mail->to_email = $email;
                $mail->to_name = sprintf("%s %s", $client->first_name, $client->last_name);
                $mail->subject = $template->subject;
                $mail->mail = $email;

                $mail->process_name = 'FORGOT PASSWORD';

                Mail::to($mail->mail)->send($mail);

                //dispatch(new sendMailJob($mail))->delay(Carbon::now()->addSeconds(5));    

            }

        }

        return "done";

    }
}
