<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\UploadImage;
use File;

class EmailController extends Controller
{
    public function create()
    {
        return view('email');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
          'email' => 'required|email',
          'subject' => 'required',
          'name' => 'required',
          'file' => 'required',
          'content' => 'required',
        ]);

        $data = [ 
            'subject' => $request->subject,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'file' => $request->file('file'),
          ];
        
          Mail::send('email-template', $data, function($message) use ($data) {
            $message->to($data['email'])
            ->subject($data['subject'])
            ->attach($data['file']->getRealPath(), ['as' => $data['file']->getClientOriginalName()]);
          });
  
          return back()->with(['message' => 'Email successfully sent!']);
      }
}
