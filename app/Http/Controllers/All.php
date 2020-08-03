<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Meal;           //<----------------
use App\Meta;
use App\Ispis;
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

    $pomData = Meal::all();


    $validator = Validator::make($request->all(), [
      'per_page' => 'nullable|integer',
      'page' => 'nullable|integer',
    //  'category' => 'nullable',
      'tags' => 'nullable|ends_with:1,2,3|starts_with:1,2,3',
      'with' => 'nullable|ends_with:categories,tags,ingredients|starts_with:categories,tags,ingredients',
      'lang' => 'required|size:2|alpha',
      'diff_time' => 'nullable|integer'
    ]);

    if ($validator->fails()) {
        return response(
            $validator->errors(),
            400
        );
    }



  //  $from_time = strtotime("1970-1-1 00:00:00");
    
    $diff_time = $request->query('diff_time');          
   // print_r('diff_time: '.$diff_time);
   // echo '<br>';



    $page = $request->query('page');   
    

    $data_kolicina = Meal::count();

    $tags = $request->query('tags');
    $tags = explode(',', $tags);                   //string to array

    
    
  //  $tags = json_decode($tags);
    if($tags[0] == null)
    goto B;


    $j=0;$m=0;
    for($i=0; $i < $data_kolicina; $i++){                     //ISPITIVANJE TAGGOVA
      $m=0;
      $pomm = sizeof(($pomData[$i]->tags));             
        for($z=0; $z < sizeof($tags); $z++){
          for($k=0; $k < $pomm; $k++){
            if(($tags[$z]) == ($pomData[$i]->tags[$k]['id'])){
              $dataPrv[$j++] = $pomData[$i];
              $m++;
              break;  
            }
            else{
              continue;
            }  
          }
          if($m > 0)
            break;  
        }
                     
    }

    
    B:
    if($tags[0] == null){  
      $dataPrv = Meal::all();
      $data_kolicina = Meal::count();
    }
    else{
      $data_kolicina = $j;
    }
   

    if($diff_time == null){
      $t=0;
      for($i=0; $i < $data_kolicina; $i++){
        if($dataPrv[$i]->deleted_at == null){
            $data[$t++] = $dataPrv[$i];
        }
      }
    }else{
      $t=0;
      for($i=0; $i < $data_kolicina; $i++){
        if(strtotime($dataPrv[$i]->deleted_at) >= ($diff_time)){
            $data[$t] = $dataPrv[$i];
            $data[$t++]->status = "deleted";
            
        }
        if(strtotime($dataPrv[$i]->created_at) >= ($diff_time) && $dataPrv[$i]->deleted_at == null){
          $data[$t++] = $dataPrv[$i];
        }
      }
    }


    
    $data_kolicina = $t;
    if($data_kolicina == 0 && $tags[0] != null){
      echo 'Ne postoji Tag sa trazenim ID-em';
      exit;
    }elseif($data_kolicina == 0 && $tags[0] == NULL){
      $data_kolicina = sizeof($pomData);
      $data = $pomData;
    }



    $per_page = $request->query('per_page');

    

   /*  if($page != 0){
      print_r('currentPage: '.$page);
    }else{
      print_r('currentPage: 1');
    } */

    /* echo '<br>';
    print_r('totalItems: '.$data_kolicina);             //GORNJE VARIJABLE
    echo '<br>'; */
    if($per_page !=0){
   //   print_r('itemsPerPage: '.$per_page);
    }else{
     // print_r('itemsPerPage: '.$data_kolicina);
    }
    //echo '<br>';




    $lang = $request->query('lang');                  //JEZIK
    setLocale(LC_ALL, $lang);
  //  print_r('LANG: '.$lang);
   // echo '<br>';
  



 /* if($tags == null)
    echo 'TAGS == NULL'; 

    $diff_time = $request->query('diff_time');
    print_r('diff_time: '.$diff_time);
    echo '<br>';
    */
 
    
  
    $data_ispis = $data_kolicina - $per_page;


    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    $with = $request->query('with');
    $with = explode(',', $with);                   //string to array

    $ispis = new Ispis;



    if($per_page==0 && $page==0){
      $totalPages= 1;
      /* print_r('totalPages: 1');
      echo '<br>';
      echo '<br>';
      echo '<br>';
      echo '<br>';
      echo '<br>';
      echo '<br>'; */
      for($i=0; $i<$data_kolicina; $i++){              	   //ispis stranice (npr. per_page 5 na page 2 sa total_items 9)
          $ispis->data = $data;
          echo "<pre>"; 
          echo json_encode($data[$i], JSON_PRETTY_PRINT);
          echo "</pre>"; 
          /* echo '<br>';
          echo '<br>'; */
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
    
    /* print_r('totalPages: '.(int)($totalPages));
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>'; */


    if($page == 0)
      $page = 1;
    if($page>$totalPages){
      echo 'Nepostojeća stranica';
      exit;
    }

   


    $polje1['currentPage'] = $page;
    $polje1['totalItems'] = $data_kolicina;
    $polje1['itemsPerPage'] = $per_page;
    $polje1['totalPages'] = $totalPages;
    $ispis->meta = $polje1;


    

    $uk=0;
    if($page == 1 || $page == 0){
      A:
      for($i=0; $i<$per_page; $i++){              	   //ispis stranice (npr. per_page 5 na page 2 sa total_items 9)
            if($with[0] == null){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status']);
              $polje3[$i] = $pom[$i];
              /* echo "<pre>"; 
              echo json_encode($pom[$i], JSON_PRETTY_PRINT);
              echo "</pre>";
              echo '<br>';
              echo '<br>'; */
            }
            if(sizeof($with) == 3){
                $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0], $with[1], $with[2]]);
                $polje3[$i] = $pom[$i];
               /*  echo "<pre>"; 
              echo json_encode($pom[$i], JSON_PRETTY_PRINT);
              echo "</pre>";
                echo '<br>';
                echo '<br>'; */
            }
            if(sizeof($with) == 2){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status',$with[0], $with[1]]);
              $polje3[$i] = $pom[$i];
              /* echo "<pre>"; 
              echo json_encode($pom[$i], JSON_PRETTY_PRINT);
              echo "</pre>";
              echo '<br>';
              echo '<br>'; */
            }
            if(sizeof($with) == 1 && $with[0] != null){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0]]);
              $polje3[$i] = $pom[$i];
              /* echo "<pre>"; 
              echo json_encode($pom[$i], JSON_PRETTY_PRINT);
              echo "</pre>";
              echo '<br>';
              echo '<br>'; */
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
              $polje3[$i] = $pom[$i];
             /*  echo json_encode($pom[$i], JSON_PRETTY_PRINT);
              echo '<br>';
              echo '<br>'; */
            }
            if(sizeof($with) == 3){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0], $with[1], $with[2]]);
              $polje3[$i] = $pom[$i];
             /*  echo json_encode($pom[$i], JSON_PRETTY_PRINT);
              echo '<br>';
              echo '<br>'; */
            }
            if(sizeof($with) == 2){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status',$with[0], $with[1]]);
              $polje3[$i] = $pom[$i];
             /*  echo json_encode($pom[$i], JSON_PRETTY_PRINT);
              echo '<br>';
              echo '<br>'; */
            }
            if(sizeof($with) == 1 && $with[0] != null){
              $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0]]);
              $polje3[$i] = $pom[$i];
             /*  echo json_encode($pom[$i], JSON_PRETTY_PRINT);
              echo '<br>';
              echo '<br>'; */
            }
          }
        }
      }
    }

    

    if($page == $totalPages && $page!=1){
      for($i=$per_page*($page-1); $i<$data_kolicina; $i++){              //ispis stranice (npr. per_page 5 na page 2 sa total_items 9)
        if($with[0] == null && strtotime($data[$i]->created_at) > $diff_time){
          $pom[$i] = $data[$i]->only(['id', 'title', 'description','status']);
          $polje3[$i] = $pom[$i];
          /* echo json_encode($pom[$i], JSON_PRETTY_PRINT);
          echo '<br>';
          echo '<br>'; */
        }      
        if(sizeof($with) == 3 && strtotime($data[$i]->created_at) > $diff_time){
          $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0], $with[1], $with[2]]);
          $polje3[$i] = $pom[$i];
          /* echo json_encode($pom[$i], JSON_PRETTY_PRINT);
          echo '<br>';
          echo '<br>'; */
        }
        if(sizeof($with) == 2 && strtotime($data[$i]->created_at) > $diff_time){
          $pom[$i] = $data[$i]->only(['id', 'title', 'description','status',$with[0], $with[1]]);
          $polje3[$i] = $pom[$i];
          /* echo json_encode($pom[$i], JSON_PRETTY_PRINT);
          echo '<br>';
          echo '<br>'; */
        }
        if(sizeof($with) == 1 && $with[0] != null && strtotime($data[$i]->created_at) > $diff_time){
          $pom[$i] = $data[$i]->only(['id', 'title', 'description','status', $with[0]]);
          $polje3[$i] = $pom[$i];
          /* echo json_encode($pom[$i], JSON_PRETTY_PRINT);
          echo '<br>';
          echo '<br>'; */
        }
      }
    }

    $ispis->data = $polje3;

    $pr = $request->query('page');


   /*  echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>'; */


    
    if($pr != 0){
      
      $prev_link = $request->fullUrl();
      $prev_link = Str::replaceFirst('page='.$pr,'page='.($pr-1), $prev_link);
      if($pr==1){
        $polje2['prev'] = null;
       /*  echo 'prev: null';
        echo '<br>'; */
      }
      else{
        $polje2['prev'] = $prev_link;
        /* echo 'prev: ';
        echo $prev_link;
        echo '<br>'; */
      }
      $next_link = $request->fullUrl();
      $next_link = Str::replaceFirst('page='.$pr,'page='.($pr+1), $next_link);

      if($pr==$totalPages){
        $polje2['next'] = null;
        /* echo 'next: null';
        echo '<br>'; */
      }else{
        $polje2['next'] = $next_link;
        /* echo 'next: ';
        echo $next_link;
        echo '<br>'; */
      }
      $self = $request->fullUrl();
      $polje2['self'] = $self;
      /* echo 'self: ';
      echo $self;
      echo '<br>'; */
    }


    else{
      $prev_link = $request->fullUrl();
      if($page == 1 || $page == 0){
        $polje2['prev'] = null;
       /*  echo 'prev: null';
        echo '<br>'; */
      }
      else{
        $polje2['prev'] = $prev_link;
        /* echo 'prev: ';
        echo $prev_link;
        echo '<br>'; */
      }
      $next_link = $request->fullUrl();

      if($page==$totalPages){
        $polje2['next'] = null;
        /* echo 'next: null';
        echo '<br>'; */
      }else{
        $polje2['next'] = $next_link.'&page='.($page+1);
        /* echo 'next: ';
        echo $next_link.'&page='.($page+1);
        echo '<br>'; */
      }
      $self = $request->fullUrl();
      $polje2['self'] = $self.'&page='.$page;
      /* echo 'self: ';
      echo $self.'&page='.$page;
      echo '<br>'; */
    }
    
  /*     $polje2['self'] = Str::replaceLast('127.0.0.1:8000', 'localhost',$polje2['self']);
      $polje2['next'] = Str::replaceLast('127.0.0.1:8000', 'localhost',$polje2['next']);
      $polje2['prev'] = Str::replaceLast('127.0.0.1:8000', 'localhost',$polje2['prev']); */


    $ispis->links = $polje2;
    


  /*    $ispis = new Ispis;
    $ispis->data = $data;
    $ispis->meta['currentPage'] = $page; */
 
    /* $ispis = Ispis::create([
       'meta' => json_encode([
        'currentPage' => $page,
        'totalItems' => $data_kolicina,
        'itemsPerPage' => $per_page,
        'totalPages' => $totalPages,
      ]), 
      'data' => json_encode($data),
       'links' => json_encode([
        'prev' => $prev_link,
        'next' => $next_link,
        'self' => $self,
      ]) 
    ]); */


    /* $ispis = new Ispis;
    $polje1['currentPage'] = $page;
    $polje1['totalItems'] = $data_kolicina;
    $polje1['itemsPerPage'] = $per_page;
    $polje1['totalPages'] = $totalPages;

    $polje2['prev'] = $prev_link;
    $polje2['next'] = $next_link;
    $polje2['self'] = $self; */
    
  
   // $ispis->data = $data;
    

    /* echo '<br>';
    echo '<br>';
    echo '<br>'; */
    echo "<pre>";
    echo json_encode($ispis, JSON_PRETTY_PRINT); 
    echo "</pre>";


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
