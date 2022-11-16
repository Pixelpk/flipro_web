<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveUserComponent extends Component
{

    protected $listeners = ['editModel' => 'edit'];

    public $type;
    public $user;
    public $name;
    public $email;
    public $address;
    public $phone_code;
    public $phone;
    public $password;
    public $userTypes = [
        'admin', 'franchise', 'builder', 'evaluator', 'home-owner'
    ];
    public $model;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'address' => 'required',
        'phone_code' => 'required',
        'phone' => 'required',
        'password' => 'required|min:6',
        'model' => 'nullable',
    ];

    public function mount()
    {
        if(!in_array($this->type, $this->userTypes)){
            return redirect("/404", 404);
        }      

        $this->user = Auth::user();

        if(!$this->user->hasRole('view-' . $this->type)) abort(403); 
    }

    public function render()
    {
        return view('livewire.live-user-component');
    }

    public function create()
    {
        $this->validate();
        $user = User::forceCreate([
            'name' => $this->name,
            'email' => $this->email,
            'phone_code' => $this->phone_code,
            'phone' => $this->phone,
            'address' => $this->address,
            'user_type' => $this->type,
            'password' => \Hash::make($this->password),
        ]); 
        
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> ucfirst(str_replace('-', ' ', $this->type)) . ' created successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
        
        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userCreateModal",
            'action' => 'hide'
        ]);
        $this->reset([
            'name', 'email', 'address', 'phone_code', 'phone', 'model'
        ]);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->model->id,
            'address' => 'required',
            'phone_code' => 'required',
            'phone' => 'required',
            'password' => 'nullable|min:6',
        ]);
        
        $this->model->name = $this->name;
        $this->model->email = $this->email;
        $this->model->phone_code = $this->phone_code;
        $this->model->phone = $this->phone;
        $this->model->address = $this->address;
        if($this->password){
            $this->model->password = \Hash::make($this->password);
        }

        $this->model->update();
        
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> ucfirst(str_replace('-', ' ', $this->type)) . ' updated successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
        
        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userCreateModal",
            'action' => 'hide'
        ]);
        $this->reset([
            'name', 'email', 'address', 'phone_code', 'phone', 'model'
        ]);
    }

    public function openModal()
    {
        $this->reset([
            'name', 'email', 'address', 'phone_code', 'phone', 'model'
        ]);
    }

    public function edit(User $user)
    {
        $this->model = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->address = $user->address;
        $this->phone_code = $user->phone_code;
        $this->phone = $user->phone;
        
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userCreateModal",
            'action' => 'show'
        ]);
    }
}
