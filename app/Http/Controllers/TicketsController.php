<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketFormRequest;
use App\Ticket;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;


class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $tickets=Ticket::latest('created_at')->get();
        //dd($tickets);
        return view('tickets.index',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketFormRequest $request)
    {
        //return $request->all();
        $slug = uniqid();
        /*$ticket = new Ticket(array(
        'title' => $request->get('title'),
        'content' => $request->get('content'),
        'slug' => $slug
        ));*/
        $ticket = new Ticket;
        $ticket->title = $request->get('title');
        $ticket->content = $request->get('content');
        $ticket->user_id = auth()->user()->id;
        $ticket->slug = $slug;
        $ticket->save();

        $data = array(
        'ticket' => $slug
        );
        Mail::send('emails.welcome', $data, function ($message) {
        $message->from('vladimirbajic5@gmail.com', 'Learning Laravel 5.5');
        $message->to('vladimirbajic5@gmail.com')->subject(' There is new ticket');

        });
        return redirect('/tickets')->with('status', 
            'Your ticket has been created! Its unique id is: '.$slug);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
       
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $comments = $ticket->comments()->orderBy('created_at','desc')->get();

        return view('tickets.show', compact('ticket','comments','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        return view('tickets.edit', compact('ticket'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($slug, TicketFormRequest $request)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->title = $request->get('title');
        $ticket->content = $request->get('content');
        if($request->get('status') != null) {
        $ticket->status = 0;
        } else {
        $ticket->status = 1;
        }
        $ticket->save();
       return redirect(action('TicketsController@index', $ticket->slug))->with('status',
      'The ticket '.$slug.' has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->delete();
        $ticket->comments()->delete();
        return redirect('/tickets')->with('status', 'The ticket '.$slug.' has been deleted!');
        

    }
}
//{{ config('app.name', 'Laravel') }}