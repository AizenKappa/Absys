<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Absysyear;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AbsysController extends Controller
{
    public function index(){
        
        return view('home');
    }

    public function addYear($controller, $array , $array_p , $year)
    {

        $newYear = $year[0].$year[1];
        
        
        Absysyear::create([
            'year' => $year[0].'-'.$year[1],
            'active' => "off",
            'current' => false
        ]);
        

        
        Artisan::call('make:model Etat'.$newYear.' -m');


        $etModelContent =
"<?php

namespace App\Models;
            
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
            
class Etat".$newYear." extends Model
{
    use HasFactory;
    public \$timestamps = false;
    protected \$guarded = [];
            
            
    protected \$with = ['prof','duration','stagiaire.groupe'];
    public function stagiaire()
    {
        return \$this->belongsTo(Stagiaire::class);
    }
            
    public function prof()
    {
        return \$this->belongsTo(Prof::class);
    }
    public function duration()
    {
        return \$this->belongsTo(Duration::class);
    }
}
";

        $etMigrationContent = 
"
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
            
return new class extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('etat".$newYear."s', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId(\"stagiaire_id\");
            \$table->foreignId(\"prof_id\");
            \$table->foreignId(\"duration_id\");
            \$table->date(\"date_abs\");
            \$table->string(\"seance\");
            \$table->string(\"etat_justif\")->default(\"NJ\");
            \$table->string(\"motif\")->default(\"---\");
            \$table->timestamps();
        });
    }
            
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('etat".$newYear."s');
    }
};
";

        $filesName = \File::files(base_path().'\database\migrations\\');

        foreach ($filesName as $file) {

            $ex = explode("\\"  , $file);
            $filename = $ex[count($ex) - 1];

            if (str_contains($filename, 'etat'.$newYear.'s')) 
            {
                $insertFile = fopen(base_path("database/migrations/".$filename),"w");
                fwrite($insertFile,$etMigrationContent);
                break;
            }
        }
        

        $insertFile = fopen(app_path("Models/Etat".$newYear.".php"),"w");
        fwrite($insertFile,$etModelContent);



        Artisan::call('migrate');
    
        
        
        Absysyear::Where('active','on')->update([
            "active" => "off",
            "current" => false,
        ]);

        $newYear = $year[0].'-'.$year[1];

        Absysyear::Where('year',$newYear)->update([
            "active" => "on",
            "current" => true,
        ]);

        return $controller->insertData($array_p,$array,$newYear);
    }

}
