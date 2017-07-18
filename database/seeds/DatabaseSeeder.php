<?php

use Illuminate\Database\Seeder;
use App\Goal;
use App\User;
use App\Subgoal;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Create 100 users each with one goal from the list
        factory(App\User::class, 100)->create()->each(function ($user) {
            $bucketList = [
                'Go Skydiving',
                'Compete in One MMA Fight',
                'Visit All 50 States',
                'See Gaudis Sagrada Familia and Explore Spain',
                'Go Bungee Jumping',
                'Visit Acropolis, Meteora, and See a Sunset in Santorini Greece',
                'See Ancient Cave Paintings',
                'Climb One of the Seven Summits',
                'Walk on the Great Wall and See Zhangjiajie in China',
                'Ride a Bull',
                'Learn Flying Trapeze',
                'Dunk a Basketball',
                'Visit Niagara Falls',
                'See Petra and Swim in the Dead Sea in Jordan',
                'Be Ranked 2000+ USCF in Chess',
                'Explore the Plitvice Lakes in Croatia',
                'Go Parasailing',
                'Hang Glide',
                'Explore New Zealand',
                'Visit Easter Island',
                'Get Arrested',
                'Complete an Olympic Distance Triathlon',
                'See Victoria Falls',
                'Visit All 7 Continents',
                'Receive Pilots License',
                'Learn How to Surf',
                'Go Hot Air Ballooning',
                'See Angel Falls',
                'Visit the Galapagos Islands',
                'Visit Stonehenge and See Big Ben',
                'Vacation in Seychelles',
                'Race a Sports Car',
                'Go Whitewater Rafting',
                'Live on an Island for a Month',
                'Get a Six Pack',
                'Learn to Kitesurf',
                'See Machu Picchu',
                'Go Scuba Diving',
                'Visit the Louvre and Stand on Top of the Eiffel Tower in Paris',
                'Take Extended Family on a Gigantic Vacation',
                'Go to a Super Bowl',
                'Do 20 Pull Ups and 100 Push Ups',
                'Learn to Speak Italian',
                'Spend at Least Three Months Traveling Through All of Italy',
                'Swim with Sharks',
                'Run with the Bulls in Spain',
                'Protest for Something I Believe In',
                'Vacation in French Polynesia',
                'Attend an Olympic Games Event',
                'Hug a Giant Redwood Tree',
                'Crash a Huge Fancy Wedding',
                'See Christ the Redeemer in Rio',
                'Get in a Fight Protecting Someone',
                'Walk on the Red Carpet and Meet a Celebrity',
                'Survive in the Wilderness',
                'Visit Myanmar',
                'Ride on the Outside of a Train',
                'Take a Trip with Friends to Las Vegas',
                'Own a Piano and Learn to Play it Well',
                'Climb to the Top of Chichen Itza',
                'See Socotra',
                'Take a Canopy Tour of the Amazon Rainforest',
                'Go on a Safari in Africa',
                'Ride the World’s Biggest Roller Coaster',
                'See Thailand',
                'Ride in a Limo',
                'Stand on the Four Corners',
                'See the Statue of Liberty and Explore the Met',
                'Ice Skate in Central Park and Spend New Years in Times Square',
                'Ride in a Helicopter',
                'See the Golden Gate Bridge and Tour Alcatraz',
                'Learn to Dance Well',
                'Swim with Crocodiles',
                'Play in a High Stakes Poker Tournament',
                'See the Colosseum',
                'Visit Mont Saint-Michel',
                'Commit a Humongous and Life Changing Act of Kindness',
                'Stand at the Top of the World’s Tallest Building',
                'Golf at Pebble Beach',
                'See the Ancient Wonders in Egypt',
                'Visit Scotland and Ireland',
                'See Angkor Wat',
                'Give a Speech to a Large Crowd',
                'Own a Business',
                'Visit the Taj Mahal',
                'See Predjama Castle',
                'Visit the Grand Canyon, Antelope Canyon, and Monument Valley in Arizona',
                'Spend the Night in a Haunted Location',
                'Ride a Camel in the Desert',
                'Learn How to Fence',
                'Tour Yellowstone National Park',
                'See All of the Landmarks in DC',
                'Visit Mount Rushmore',
                'Watch a Formula One Race and Gamble in Monaco',
                'See the Fjords of Norway',
                'Watch Sumo Wrestling in Japan',
                'Motorcycle Down Highway 1 and See Hearst Castle',
                'Visit the San Diego Zoo',
                'Invest in Real Estate',
                'Go Spelunking',
            ];

            $goalName = $bucketList[$user->id - 1];
            $goalCost = rand(0, 10000);
            $goalHours = rand(0, 300);
            $goalDays = rand(0, 30);
            $user->newGoal($goalName, $goalCost, $goalHours, $goalDays);
        });

        //Get the 100 users and 100 goals as collections
        $users = User::take(100)->get();
        $goals = Goal::take(100)->get();

        //For each user add a random goal to their bucket list
        foreach ($users as $user)  {
            $rand = rand(1, 99);

            if ($rand != $user->id) {
                $goal = $goals[$rand];
                $goal->createDefaultSubgoal($user);
            }

        }

        //Get all goals as collection, then loop through and update the goal averages
        // I still am kind of shaky on why this is necessary, should readdress this later
        $all = Goal::all();

        $all->each(function($g) {
            $g->updateGoalAverages();
        });


        //Create base user for myself
        $user = User::create([
            'name' => 'Mike',
            'email' => 'mike@email.com',
            'password' => bcrypt('password'),
            'admin' => true,
        ]);

        $user->createProfile();

    }
}
