<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Postion;

class PositionController extends Controller
{
    public function showPosition(){
        $menu_level1='position';
        $menu_level2='';
        return view('position',compact('menu_level1','menu_level2'));
    }

    public function getPositions(){
        $result=Array();
        $positions=Postion::all();
        $i=0;
        foreach ($positions as $position){
            $result[$i]['name']=$position->name;
            $result[$i]['ID']=$position->id;
            $i++;
        }
        return response($result)->withHeaders([
            'Content-Type' => 'application/json',
        ]);
    }

    public function insertPosition(Request $request){
        $item=$request->all();
        $position_name=$item['name'];

        $temps=Postion::where('name',$position_name)->get();
        if (!$temps->first()){
            $position=new Postion;
            $position->name=$position_name;
            $position->save();
            $item['ID']=$position->id;
            return response($item)->withHeaders([
                'Content-Type' => 'application/json',
            ]);
        }
        return "non";
    }

    public function updatePosition(Request $request){
        $item=$request->all();
        $id=$item['ID'];
        $position_name=$item['name'];

        $position=Postion::find($id);
        if ($position){
            $position->name=$position_name;
            $position->save();
            $item['ID']=$position->id;
            return response($item)->withHeaders([
                'Content-Type' => 'application/json',
            ]);
        }
    }

    public function deletePosition(Request $request){
        $item=$request->all();
        $id=$item['ID'];

        $position=Postion::find($id);
        if ($position){
            $position->delete();
        }
    }

}