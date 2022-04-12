<?php
	namespace Controllers;

	use Models\Bid;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Bids{
		// CREATE
	    public static function create($package_id, $bidder_id, $offer){
	    	$created = Bid::firstOrCreate(['package_id' => $package_id, 'bidder_id' => $bidder_id, 'offer' => $offer]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Bid::all();

	        return $get;
	    }

	    public static function find_bybidder($bidder_id, $package_id){
	        $get = Bid::where('bidder_id', $bidder_id)->where('package_id', $package_id)->first();

	        return $get;
	    }

	    public static function find_bypackage($package_id){
	        $get = Bid::where('package_id', $package_id)->orderBy('offer', 'desc')->get();

	        return $get;
	    }

	    public static function find_byuser($package_id, $user_id){
	        $get = Bid::where('bidder_id', $user_id)->where('package_id', $package_id)->first();

	        return $get;
	    }

	    // UPDATE
	    public static function update($id, $package_id, $bidder_id, $offer){
	        $_update = Bid::find($id);

	        $_update->package_id = $package_id;
	        $_update->bidder_id = $bidder_id;
	        $_update->offer = $offer;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Bid::find($id);

	        return $_destroy->delete();
	    }
	}
?>