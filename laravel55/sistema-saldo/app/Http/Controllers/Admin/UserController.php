<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateProfileFormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\File;

class UserController extends Controller
{
    //

    public function profile()
    {
        return view('admin.profile.index');
    }

    public function profileUpdate(UpdateProfileFormRequest $request)
    {
        /*$user = auth()->user();

        $data = $request->except(['_token']);

        if($data['password'] != null){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        $data['image'] = $user->image;

        if($request->hasFile('image') && $request->file('image')->isValid()){

            if($user->image)
                $name = $user->image;
            else
                $name = $user->id.kebab_case($user->name);

            $extencao = $request->image->extension();

            $nameFile = "{$name}.{$extencao}";

            $upload = $request->image->storeAs('users', $nameFile);

            if(!$upload)
                return redirect()->back()->with('error', 'Não foi possível alterar sua imagem de perfil!');

            $data['image'] = $nameFile;
        }

        /*$exists = Storage::disk('public')->exists('users/'.$name);
        $del = Storage::disk('public')->delete('users/'.$name);*/
/*
        $update = auth()->user()->update($data);

        if($update){
            return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Não foi possível atualizar seu perfil!');*/

        $user = auth()->user();

        $data = $request->except(['_token']);

        if($data['password'] != null){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        $data['image'] = $user->image;

        if($request->hasFile('image') && $request->file('image')->isValid()){

            if($user->image)
                $file = ($user->image);
            else{
                $file = md5(time().$user->id.kebab_case($user->name));
                //$file = md5(kebab_case($user->name).$user->id);
            }

            $existFile = Storage::disk('public')->exists('users/'.$file);
            if($existFile)
                Storage::disk('public')->delete('users/'.$file);

            $extension = $request->image->extension();
            $nameFile = explode('.', $file);
            $fileUpload = "{$nameFile[0]}.{$extension}";

            $upload = $request->image->storeAs('users', $fileUpload);

            if(!$upload)
                return redirect()->back()->with('error', 'Não foi possível alterar sua imagem de perfil!');

            $data['image'] = $fileUpload;
        }

        $update = auth()->user()->update($data);

        if($update){
            return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Não foi possível atualizar seu perfil!');
    }
}
