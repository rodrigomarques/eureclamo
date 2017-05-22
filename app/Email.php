<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /*
     create table email(EMAIL_id integer auto_increment,EMAIL_ano integer,EMAIL_tipo varchar(100),
     EMAIL_status integer,
     EMAIL_destinatario varchar(100),
     primary key(EMAIL_id, EMAIL_ano));
     */
    protected $table = "email";
    //protected $primaryKey = "ANEXO_MANIF_idAnexo";
    public $timestamps = false;
    protected $fillable = ['EMAIL_id','EMAIL_ano','EMAIL_tipo','EMAIL_status',
    'EMAIL_destinatario'];

    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    
}
