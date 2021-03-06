<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
//use Illuminate\Validation\Validator;
use DB;

use Validator;


class EventController extends Controller {

    private $upgradeableUserFields = ['name', 'descr', 'address', 'event_start', 'event_end', 'event_type'];

    public function index() {
        return Response::json(Events::all());
    }
	
	public function getList($id) {
		$number = 3;
		return Response::json(DB::table('events')->take($number)->skip((intval($id)-1) * $number)->get());
        //return Response::json(Event::all()->skip(($id-1) * $number)->take($number));
    }
	
	public function getlast() {
		//->skip(10)->take(5)->get();
		return Response::json(Events::all()-> take(3));
	}
	
    public function delete(Events $event) {
        if (is_null($event)) return ['success' => false, 'error' => 'event not found'];
        $event->delete();
        return ['success' => true];
    }

    public function create(Request $request) {
        $data = $request->all();

       // $validator = Validator::make($data, [
        //    'name' => 'required|max:255', 'descr' => 'required', 'address' => 'required',
       //     //'type' => 'required|event_types,id'
       // ]);
		
		// TODO исправить 
       // if ($validator->fails()) return Response::json(['success' => false, 'error' => $validator->errors()->all()]);
       // $params = [
       //     'name' => $data['name'], 'descr' => $data['descr'], 'event_type' => $data['type']
		//];
        /*$validator = Validator::make($data, [
            'name' => 'required|max:255',
            'descr' => 'required',
            'address'=> 'required',
            'type' => 'required|event_types,id',
        ]);*/
		// TODO исправить, add address
       /* if ($validator->fails()) return Response::json(['success' => false, 'error' => $validator->errors()->all()]);*/
        /*$params = [
            'name' => $data['name'], 'descr' => $data['descr'], 'event_type' => $data['type'], 'address' => $data['address'],

        ];
        foreach (['event_start', 'event_end', 'address'] as $item) if (isset($data[$item]) && !is_null($data[$item])) {
            $params['event_start'] = $data[$item];
        }*/
		
		$val = Validator::make($data, ['name' => 'required']);
        if ($val->fails()) return Response::json(['success' => false, 'error' => $val->errors()->all()]);
		
        Events::create([
            'name' => $data['name'],
            'descr' => $data['descr'],
            'address' => $data['address'],
            'event_type' => $data['event_type'],
            'event_start' => $data['event_start'],
            'event_end' => $data['event_end'],
        ]);
        return Response::json(['success' => true]);
		
		//if (is_null($event)) return ['success' => false, 'error' => 'null event'];
        //else return ['success' => true, 'id' => 4];
    }

    public function update(Request $request, Events $id) {
        if (is_null($id)) {
            return ['success' => false, 'event not found'];
        } else {
            // todo запилить разрешения
            $updated = [];
            foreach ($request as $key => $value) {
                if (in_array($key, $this->upgradeableUserFields)) {
                    try {
                        $id->{$key} = $value;
                        $id->save();
                    } finally {
                        $updated[] = $key;
                    }
                }
            }
            return ['success' => count($updated) != 0, 'fields' => $updated];
        }

    }

    public function show(Events $id) {
        if (is_null($id)) {
            return ['success' => false, 'error' => 'event not found'];
        } else {
            return ['success' => true, 'event' => $id];
        }

    }

    // public function viewAll() {
    //     $data = $this->index();
    //     return view('backend/events/viewAll', ['data' => $data]);
    // }
}
