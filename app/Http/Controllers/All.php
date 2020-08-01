<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Meal;           //<----------------
use App\Meta;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Expr\Cast\Int_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Assign;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\json_encode;

class All extends Controller
{
    

   /*  public function link(int $per_page){
        $pr = $per_page;

        echo ($pr);
        dd($per_page);
    } */

    public function link(Request $request){
      $data = Meal::all();

      $per = $request->getPathInfo();
      $per_page = Str::after($per,'=');

      dd($per_page);
  }

  public function dbCheck(){
      
    /* $meal = DB::table('meals')
    ->where('id', '1')
    ->get(); */

    $meal = DB::table('meals');

    dd($meal);
  }
    






  public function show(Request $request){
/* 
   $validator = $request->validate([
      'per_page' => 'nullable',
      'page' => 'nullable',
      'category' => 'nullable',
      'tags' => 'nullable',
      'with' => 'nullable',
      'lang' => 'required',
      'diff_time' => 'nullable'
    ]);  */

    $pomData = Meal::all();



    $validator = Validator::make($request->all(), [
      'per_page' => 'nullable',
      'page' => 'nullable',
      'category' => 'nullable',
      'tags' => 'nullable',
      'with' => 'nullable',
      'lang' => 'required',
      'diff_time' => 'nullable'
    ]);

    if ($validator->fails()) {
        return response(
            $validator->errors(),
            400
        );
    }




    $page = $request->query('page');   
    

    $data_kolicina = Meal::count();

    $tags = $request->query('tags');
   // print_r('tags: '.$tags);


    $j=0;
    for($i=0; $i<$data_kolicina; $i++){
      if($tags == $pomData[$i]->tags->id){
        $data[$j++] = $pomData[$i];
      }
      else{
        continue;
      }
    }
    

    $data_kolicina = $j;
    if($data_kolicina == 0 && $tags != null){
      echo 'Ne postoji Tag sa trazenim ID-em';
      exit;
    }elseif($data_kolicina == 0 && $tags == NULL){
      $data_kolicina = sizeof($pomData);
      $data = $pomData;
    }



    $per_page = $request->query('per_page');

    

    if($page != 0){
      print_r('currentPage: '.$page);
    }else{
      print_r('currentPage: 1');
    }

    echo '<br>';
    print_r('totalItems: '.$data_kolicina);
    echo '<br>';
    if($per_page !=0){
      print_r('itemsPerPage: '.$per_page);
    }else{
      print_r('itemsPerPage: '.$data_kolicina);
    }
    echo '<br>';
    

   /*  if($tags == null)
      echo 'TAGS == NULL'; */

    /* $per_page = $request->query('per_page');
    $with = $request->query('with');
    $tags = $request->query('tags');
    $lang = $request->query('lang');
    $diff_time = $request->query('diff_time');
    $page = $request->query('page');

    print_r('per page: '.$per_page);
    echo '<br>';
    print_r('tags: '.$tags);
    echo '<br>';
    print_r('lang: '.$lang);
    echo '<br>';
    print_r('with: '.$with);
    echo '<br>';
    print_r('diff_time: '.$diff_time);
    echo '<br>';
    print_r('page: '.$page);
    echo '<br>'; */

    
  
    $data_ispis = $data_kolicina - $per_page;


    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    $with = $request->query('with');
    $with = explode(',', $with);                   //string to array





    /* foreach($with as $w){
      print_r('with: '.$w);
      echo '<br>';
    }
    echo sizeof($with);
    echo '<br>'; */


   /*  $he = $data[0]->tags->id; 
    echo $he;


    echo '<br>';
    echo '<br>';
    echo '<br>';

    echo $tags;

    echo '<br>';
    echo '<br>';
    echo '<br>'; */

    if($per_page==0 && $page==0){
      $totalPages= 1;
      print_r('totalPages: 1');
      echo '<br>';
      echo '<br>';
      echo '<br>';
      echo '<br>';
      echo '<br>';
      echo '<br>';
      for($i=0; $i<$data_kolicina; $i++){              	   //ispis stranice (npr. per_page 5 na page 2 sa total_items 9)
           print_r(json_encode($data[$i]));
          echo '<br>';
          echo '<br>';
      }
      goto A;
    }elseif($per_page != 0){
      $totalPages = (int)($data_kolicina/$per_page+0.9);
    }else{
      $totalPages = 1;
      $page = $request->query('page');
      if($page != 1){
        echo 'Nepostojeća stranica';
        exit;
      }
      $per_page = $data_kolicina;
    }
    
    print_r('totalPages: '.(int)($totalPages));
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';


    if($page == 0)
      $page = 1;
    if($page>$totalPages){
      echo 'Nepostojeća stranica';
      exit;
    }

   

    

    $uk=0;
    if($page == 1 || $page == 0){
      A:
      for($i=0; $i<$per_page; $i++){              	   //ispis stranice (npr. per_page 5 na page 2 sa total_items 9)
            if($with[0] == null){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status']);
              print_r(json_encode($pom[$i]));
              echo '<br>';
              echo '<br>';
            }
            if(sizeof($with) == 3 ){
                $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0], $with[1], $with[2]]);
                print_r(json_encode($pom[$i]));
                echo '<br>';
                echo '<br>';
            }
            if(sizeof($with) == 2){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status',$with[0], $with[1]]);
              print_r(json_encode($pom[$i]));
              echo '<br>';
              echo '<br>';
            }
            if(sizeof($with) == 1 && $with[0] != null){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0]]);
              print_r(json_encode($pom[$i]));
              echo '<br>';
              echo '<br>';
            }
            if($data_kolicina == ++$uk)
              break;
        }    
    }


    if($totalPages>2){
      for($br = 2; $br<$totalPages; $br++){
        if($page == $br){
          for($i=$per_page*($br-1); $i<$per_page*$br; $i++){              //ispis stranice (npr. per_page 5 na page 2 sa total_items 9)
            if($with[0] == null){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status']);
              print_r(json_encode($pom[$i]));
              echo '<br>';
              echo '<br>';
            }
            if(sizeof($with) == 3 ){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0], $with[1], $with[2]]);
              print_r(json_encode($pom[$i]));
              echo '<br>';
              echo '<br>';
            }
            if(sizeof($with) == 2){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status',$with[0], $with[1]]);
              print_r(json_encode($pom[$i]));
              echo '<br>';
              echo '<br>';
            }
            if(sizeof($with) == 1 && $with[0] != null){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0]]);
              print_r(json_encode($pom[$i]));
              echo '<br>';
              echo '<br>';
            }
          }
        }
      }
    }

    if($page == $totalPages && $page!=1){
      for($i=$per_page*($page-1); $i<$data_kolicina; $i++){              //ispis stranice (npr. per_page 5 na page 2 sa total_items 9)
        if($with[0] == null){
          $pom[$i] = $data[$i]->only(['id', 'title', 'description','status']);
          print_r(json_encode($pom[$i]));
          echo '<br>';
          echo '<br>';
        }      
        if(sizeof($with) == 3 ){
          $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0], $with[1], $with[2]]);
          print_r(json_encode($pom[$i]));
          echo '<br>';
          echo '<br>';
        }
        if(sizeof($with) == 2){
          $pom[$i] = $data[$i]->only(['id', 'title', 'description','status',$with[0], $with[1]]);
          print_r(json_encode($pom[$i]));
          echo '<br>';
          echo '<br>';
        }
        if(sizeof($with) == 1 && $with[0] != null){
          $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0]]);
          print_r(json_encode($pom[$i]));
          echo '<br>';
          echo '<br>';
        }
      }
    }



    $pr = $request->query('page');
 /*    echo 'PR : '.$pr;
    echo '<br>';

    echo 'PAGE : '.$page;
    echo '<br>';
    echo '<br>';
    echo '<br>';  */

    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    
    if($pr != 0){
      
      $prev_link = $request->fullUrl();
      $prev_link = Str::replaceFirst('page='.$pr,'page='.($pr-1), $prev_link);
      if($pr==1){
        echo 'prev: null';
        echo '<br>';
      }
      else{
        echo 'prev: ';
        echo $prev_link;
        echo '<br>';
      }
      $next_link = $request->fullUrl();
      $next_link = Str::replaceFirst('page='.$pr,'page='.($pr+1), $next_link);

      if($pr==$totalPages){
        echo 'next: null';
        echo '<br>';
      }else{
        echo 'next: ';
        echo $next_link;
        echo '<br>';
      }
      $self = $request->fullUrl();
      echo 'self: ';
      echo $self;
      echo '<br>';
    }


    else{
      $prev_link = $request->fullUrl();
      if($page == 1 || $page == 0){
        echo 'prev: null';
        echo '<br>';
      }
      else{
        echo 'prev: ';
        echo $prev_link;
        echo '<br>';
      }
      $next_link = $request->fullUrl();

      if($page==$totalPages){
        echo 'next: null';
        echo '<br>';
      }else{
        echo 'next: ';
        echo $next_link.'&page='.($page+1);
        echo '<br>';
      }
      $self = $request->fullUrl();
      echo 'self: ';
      echo $self.'&page='.$page;
      echo '<br>';
    }
    
 



  }



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





  public function index(){
    // $meta = Meta::all();
   //  $link = Link::all();

     $data = Meal::all();
     

     //header('Content-Type: application/json');

   //  print_r($meta);

     dd ($data);
 }


}
