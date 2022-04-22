<?php
	namespace Controllers;

	use Models\Bid;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Bids{
		// CREATE
	    public static function create($package_id, $bidder_id, $offer, $status_id, $deadline){
	    	$created = Bid::firstOrCreate(['package_id' => $package_id, 'bidder_id' => $bidder_id, 'offer' => $offer, 'status_id' => $status_id, 'deadline' => $deadline]);

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

	    public static function find_bypackage($package_id, $useris_admin = false){
	        $get = Bid::where('package_id', $package_id);

	        if(!$useris_admin){
	        	$now = date('Y-m-d h:i:s');

	        	$get = $get->join('status', 'status.id', 'bids.status_id')->where('status.status', 'active')->select('bids.*')->where('deadline', '>=', $now);
	        }

	        return $get->orderBy('deadline', 'asc')->get();
	    }

	    public static function find_byuser($package_id, $user_id){
	        $get = Bid::where('bidder_id', $user_id)->where('package_id', $package_id)->first();

	        return $get;
	    }

	    // UPDATE
	    public static function update($id, $package_id, $bidder_id, $offer, $deadline){
	        $_update = Bid::find($id);

	        $_update->package_id = $package_id;
	        $_update->bidder_id = $bidder_id;
	        $_update->offer = $offer;
	        $_update->deadline = $deadline;
	        
	        return $_update->save();
	    }

	    public static function update_status($id, $status_id){
	        $_update = Bid::find($id);

	        $_update->status_id = $status_id;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Bid::find($id);

	        return $_destroy->delete();
	    }

	    public static function delete_expiredbids()
	    {
	    	$now = date('Y-m-d h:i:s');

	        $get = Bid::where('deadline', '<', $now);

	        return $get->delete();
	    }
	}
?>