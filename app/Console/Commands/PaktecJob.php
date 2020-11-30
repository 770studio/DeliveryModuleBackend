<?php

namespace App\Console\Commands;

use App\PaktecOwnItems;
use App\PaktecCompetitorsItems;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use simplehtmldom\HtmlWeb;

class PaktecJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paktec:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        // update competitors
       $items = PaktecCompetitorsItems::limit(20)->get(); // ->with('origin')->get();
        foreach($items as $item) {
           // $listing_id = $item->listing_id;
           // dd($item->id, $item->origin_id, $item->origin->price );
            $this->updateItem( $item );

        }


        // update own items

        $items = PaktecOwnItems::limit(5)->with('competitors')->get();
        foreach($items as $item) {
            $this->updateItem(  $item );
            $minPrice = $item->competitors->min('price');
            $winner = $item->competitors->where('price', $minPrice)->first();


            if($minPrice <= (float) $item->price) {
                $item->best_seller = $winner ? $winner->id : null;
            } else $item->best_seller = 0; // my item is the lowest price


            $item->save();




        }



        dump("FINISHED!");

    }


    function updateItem( & $item) {

        try {
            $client = new HtmlWeb();
            $html = $client->load('https://www.trademe.co.nz/Browse/Listing.aspx?id=' . $item->listing_id );
            #TODO error handling
            $price = $html->find('div.buy-now-price-text', 0 )->plaintext ;

            if(!$item->title)  $item->title =  $html->find('div#ListingTitleBox_TitleText', 0 )->plaintext ;

            $item->price = trim($price, ' $');
            $item->save();

        } catch (\Exception $e) {
            // update it next time may be
            dump($e->getLine() . ' | ' . $e->getMessage() );
        }



    }


    function getOwnProduct() {

        $client = new HtmlWeb();
        $html = $client->load('https://www.trademe.co.nz/stores/paktec');


        $listings = $html->find('div.supergrid-listing' ) ;
        // foreach($listings as $listing) echo $listing->plaintext;

        if(!@count($listings)) throw new \Exception('No listings found at the origin source, origin is not available ? ');
        dump('found origin listings on 1st page:', count($listings)   );

        $rand = rand(0, count($listings) );
        $rand = $listings[$rand];
        $this->origin = $this->getOneItem( $rand );

        dump('use origin listing for comparison:', $this->origin   );


        $this->origin->file_name =  $file =  basename($this->origin->im_url);
        Storage::put($file, file_get_contents( $this->origin->im_url ));


        dump('origin listing image:',   Storage::url( $file )  );
        echo('<img src="' . Storage::url( $file ) . '">'    );


        return $this->origin;
    }




    function getForeign()
    {

        $title = urlencode($this->origin->title);
        //  $title = 'Macrame Hanging Swing Chair';
        $search_url = "https://www.trademe.co.nz/Browse/SearchResults.aspx?searchString={$title}&type=Search&searchType=all&user_region=&user_district=0&generalSearch_keypresses=2&generalSearch_suggested=0&generalSearch_suggestedCategory=&category_suggest=0";

        $client = new HtmlWeb();
        $html = $client->load($search_url);

        $listings = $html->find('div.supergrid-listing' ) ;

        dump('search request by title:',   $search_url  );
        dump('found foreign listings with search request by title:',   $this->origin->title  );
        dump('total foreign listings count on 1st page:', count($listings));

        foreach($listings as $listing) {

            $item = $this->getOneItem( $listing );
            if($item->im_url == $this->origin->im_url) continue;


            dump('fetched foreign item: ',  $item->title   );

            $file  =     basename($item->im_url);
            Storage::put($file, file_get_contents($item->im_url ));
            dump('fetched foreign item image: ',  Storage::url($file)   );
            dump('start image comparison' );

            // compare image
            $editor = Grafika::createEditor(); // Create editor
            $hammingDistance = $editor->compare( Storage::path($this->origin->file_name), Storage::path($file) );
            if($hammingDistance <=15) {
                dump('image recognized as similar' );

                $item->distance = $hammingDistance;
                $item->file_name = $file;
                $this->foreigns[] = $item;
            } else {
                dump('image recognized as not similar, proceed to the next item' );


            }





        }



    }


    function getOneItem( & $item )
    {

        $price = $item->find('div.listingBuyNowPrice', 0)->plaintext;
        $image = $item->find('div.image', 0)->style;
        $n = sscanf($image, "background-image:url('%[^\']');", $im_url);
        if(!$n ) throw new \Exception('Can not get image of the product ');

        return
            (object) [
                'title' => $item->find('div.title', 0)->plaintext,
                'price' => $price,
                '_price' => (float) trim($price, ' $'),
                'im_url' => $im_url,

            ] ;
    }







}
