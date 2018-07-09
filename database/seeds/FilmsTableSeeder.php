<?php

use Illuminate\Database\Seeder;
use App\Film;
use App\Film_comment;

class FilmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $film = new Film();
        $film->name = "The Godfather";
        $film->description = "When the aging head of a famous crime family decides to transfer his position to one of his subalterns, a series of unfortunate events start happening to the family, and a war begins between all the well-known families leading to insolence, deportation, murder and revenge, and ends with the favorable successor being finally chosen.";
        $film->release_date = "1972-03-24";
        $film->rating = 5;
        $film->ticket_price = 25;
        $film->country = "UNITED STATES";
        $film->genre = "CRIME,DRAMA";
        $film->photo = "";
        $film->save();

        $film_comment = new Film_comment();
        $film_comment->name = "Mahesh";
        $film_comment->comment = "Nice movie";
        $film_comment->film_id = $film->id;
		$film_comment->save();        

        $film = new Film();
        $film->name = "The Godfather 2";
        $film->description = "When the aging head of a famous crime family decides to transfer his position to one of his subalterns, a series of unfortunate events start happening to the family, and a war begins between all the well-known families leading to insolence, deportation, murder and revenge, and ends with the favorable successor being finally chosen.";
        $film->release_date = "1972-03-24";
        $film->rating = 5;
        $film->ticket_price = 25;
        $film->country = "UNITED STATES";
        $film->genre = "CRIME,DRAMA";
        $film->photo = "";
        $film->save();

        $film_comment = new Film_comment();
        $film_comment->name = "Mahesh";
        $film_comment->comment = "Nice movie";
        $film_comment->film_id = $film->id;
		$film_comment->save();

        $film = new Film();
        $film->name = "The Godfather 3";
        $film->description = "When the aging head of a famous crime family decides to transfer his position to one of his subalterns, a series of unfortunate events start happening to the family, and a war begins between all the well-known families leading to insolence, deportation, murder and revenge, and ends with the favorable successor being finally chosen.";
        $film->release_date = "1972-03-24";
        $film->rating = 5;
        $film->ticket_price = 25;
        $film->country = "UNITED STATES";
        $film->genre = "CRIME,DRAMA";
        $film->photo = "";
        $film->save();

        $film_comment = new Film_comment();
        $film_comment->name = "Mahesh";
        $film_comment->comment = "Nice movie";
        $film_comment->film_id = $film->id;
		$film_comment->save();
    }
}
