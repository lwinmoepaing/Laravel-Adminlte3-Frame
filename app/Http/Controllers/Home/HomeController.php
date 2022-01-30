<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class HomeController extends Controller
{
    //
    public function index() {
        return view('auth.login');
    }

    public function postMail(Request $request) {

        return $this->testMakeICS($request);
    }

    public function testMakeICS(Request $request) {
        $title = $request->title;
        $to_email = $request->to_email;
        $request_from = $request->from_recipient;

        $startDate = '7 March 2022 13:00';
        $endDate = '7 March 2022 14:00';
        $calendar = Calendar::create();
        $events = Event::create('Invitation: Meeting')
                ->startsAt(new DateTime($startDate))
                ->endsAt(new DateTime($endDate))
                ->address('Uab Tower')
                ->description('Some Testing Description');
        $ics = $calendar->event($events)->get();

        $extension = '.ics';
        $file = 'invite';

        file_put_contents($file . $extension,
            mb_convert_encoding($ics , "UTF-8", "auto")
        );

        $data = [
            'title' => $title,
            'to_email' => $to_email,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'request_from' => $request_from,
        ];

        Mail::send('invitation-email', $data, function($message) use ($title, $to_email, $file, $extension) {
            $message
                ->to($to_email)
                ->subject("$title")
                ->attach($file.$extension, ['mime' => 'data:text/calendar;charset=UTF-8;method=REQUEST']);
        });

        $data['is_back'] = true;
        return view('invitation-email', $data);
    }

    function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}
