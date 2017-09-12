<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Team extends Model
{
    protected $fillable = ['name', 'size'];

    public function add($users){
    	$this->guardAgainstToManyMembers($users);

    	if($users instanceof User){
    		return $this->memebers()->save($users);
    		// patikrina ar saugom vieną userį ir tada jį išsaugo
    	}

    	$this->memebers()->saveMany($users);
    // behind the scene prideda team_id userio lentelei. saves member
    }

    public function remove($users = null){
    	// if(!$user){
    	// 	return $this->memebers()->update(['team_id' => null]);
    	// }
    	if($users instanceof User){

    		return $users->leaveTeam();

    	}


    	return $this->removeMany($users);


    	// $this->memebers()->where('id', $user->id)->delete();
    }

    public function removeMany($users){
    	$userIds = $users->pluck('id');

    	return $this->memebers()
    				->whereIn('id', $userIds)
    				->update(['team_id' => null]);
    }

    public function restartTeam(){
    	return $this->memebers()->update(['team_id' => null]);
    }

    public function memebers(){
    	return $this->hasMany(User::class);
    }

    public function count(){
    	return $this->memebers()->count();
    }

    public function maximumSizeOfTheTeam(){
    	return $this->size;
    }

    public function guardAgainstToManyMembers($users){

    	$numberOfUsersToAdd = ($users instanceof User) ? 1 : $users->count();

    	$newTeamCount = $this->count() + $numberOfUsersToAdd;

    	if($newTeamCount > $this->maximumSizeOfTheTeam()){
    		throw new \Exception;
    	}
    	// neleidžia pridėti daugiau nei yra userių leistina komandoje
    }
}
