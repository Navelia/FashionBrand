<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function addCustomer(Request $request){
        $this->authorize('owner');
        $request->validate(['name'=>'required','email'=>'required|email:rfc,dns','phone'=>'required','address'=>'required','password'=>'required|min:8', 'conf_password'=>'required|same:password'],['password.min'=>'Panjang password minimum 8 karakter','conf_password.same'=>'Konfirmasi password tidak sama!']);

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->role = 'customer';
        $user->save();

        $customer = new Customer();
        $customer->address = $request->get('address');
        $customer->phone_number = $request->get('phone');
        $customer->points = 0;
        $customer->user_id = $user->id;
        $customer->save();

        return redirect()->route('customer.index')->with('status', 'Data member berhasil ditambah!');
    }
}
