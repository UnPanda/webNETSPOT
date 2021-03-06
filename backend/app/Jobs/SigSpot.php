<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class SigSpot implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $path;

  public function __construct($path)
  {
    $this->path = $path;
  }

  public function handle()
  {
    $job_col["status"] = "processing";
    $job_table = DB::table("jobs")->where("filename", $this->path)->update($job_col);
    exec("cd '/var/www/html/webnetspot/netspot/'; java -cp lib/GraphLib.jar:lib/meden.jar:lib/oplall.jar:lib/Refine.jar:. SigSpot wikipedia990.quadruples 10 10 output/" . $this->path . " > /dev/null 2>/dev/null &");
  }

}
