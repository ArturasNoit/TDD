<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Team;
use App\User;

class TeamTest extends TestCase
{
	/** @test */
  public function a_team_has_a_name(){

  	$team = new Team(['name' => 'Acme']);

  	$this->assertEquals('Acme', $team->name);
  }

  /** @test */
  public function team_can_add_members(){

  	$team = factory(Team::class)->create();

 	$user = factory(User::class)->create();
 	$user2 = factory(User::class)->create();

 	$team->add($user);
 	$team->add($user2);

 	$this->assertEquals(2, $team->count());
  }
  /** @test */
  public function a_team_has_a_maximum_size(){

  	$team = factory(Team::class)->create(['size' => 2]);

  	$user1 = factory(User::class)->create();
  	$user2 = factory(User::class)->create();

  	$team->add($user1);
  	$team->add($user2);

  	$this->assertEquals(2, $team->count());

  	$this->expectException("Exception");
  	$team->add($user3);

  }

  /** @test */
  public function when_adding_many_members_at_once_you_may_still_not_exeed_maximum_size(){
  	$team = factory(Team::class)->create(['size' => 2]);

  	$users = factory(User::class, 3)->create();

  	$this->expectException('Exception');

  	$team->add($users);
  }

  /** @test */
  public function a_team_can_add_multiple_members_at_once(){

  	$team = factory(Team::class)->create();

 	$users = factory(User::class, 2)->create();

 	$team->add($users);


 	$this->assertEquals(2, $team->count());
  }

  /** @test */
  public function a_team_can_remove_a_memeber(){

  	$team = factory(Team::class)->create();

 	$user = factory(User::class)->create();
 	$user2 = factory(User::class)->create();

 	$team->add($user);
 	$team->add($user2);

 	$team->remove($user2);

 	$this->assertEquals(1, $team->count());


  }

  /** @test */
  public function a_team_can_remove_more_than_one_memeber_at_once(){

  	$team = factory(Team::class)->create();

 	$users = factory(User::class, 3)->create();

 	$team->add($users);

 	$team->remove($users->slice(0, 2));

 	$this->assertEquals(1, $team->count());
  }

  /** @test */
  public function a_team_can_remove_all_members_at_once(){

  	$team = factory(Team::class)->create();

 	$users = factory(User::class, 2)->create();

 	$team->add($users);

 	$team->restartTeam();

 	$this->assertEquals(0, $team->count());
  }
}
