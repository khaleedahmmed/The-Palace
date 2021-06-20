<?php


namespace App\Helper;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\Models\Message;
use App\User;
    class Helper{

        public static function imageUploade($image, $path = '', $name = null)
        {
            $url = url('/');
            $name == null ?   $rename = rand(2000, 365840) . '_' . time() . '.' . $image->getClientOriginalExtension() : $rename = $name;
            if (is_dir(public_path('uploads/' . $path)) == false) {
                mkdir(public_path('uploads/' . $path), 0777, true);
            }
            $image->move(public_path('uploads/' . $path), $rename);

           // if you are on host add public/uploads/ instead of uploads/
            return  asset('uploads/'.$path. '/' . $rename);
        }

       public static function removeImage($image,$name = null)
        {    
             
           unlink('uploads/'.$name.'/'.$image);
       }

       public static function countUnRead()
        {    
            $unRead=Message::where('sender_id', '!=' , 1)->where('admin_view', 0)->count();
           return $unRead;
       }

       public static function messages()
        {    
           return Message::where('sender_id', '!=' , 1)->orderBy('id', 'desc')->get();
       }

       public static function pushNotification($name,$message,$user_id){

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        
        $notificationBuilder = new PayloadNotificationBuilder($name);
        $notificationBuilder->setBody($message)
                            ->setSound('default');
        
        $dataBuilder = new PayloadDataBuilder();
       // $dataBuilder->addData(['a_data' => 'my_data']);
        
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        
        // You must change it to get your tokens
        $tokens = User::find($user_id)->pluck('device_token')->whereNotNull()->toArray();
    
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        
        // return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();
        
        // return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();
        
        // return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();
        
        // return Array (key:token, value:error) - in production you should remove from your database the tokens present in this array
        $downstreamResponse->tokensWithError();

        
     }
    }
