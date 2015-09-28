<?php
class Biatloner_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }
    function create_new_biatloner($team_id)
    {
        $querys['b_id']='';
        $querys['team_id']=$team_id;
        
        $querys['age']=15;
        $querys['national']=1;//брать из страны команды, пока 1 для Германии
        
        $querys['name1']='Thomas';//сделать рандом из базы имен
        $querys['name2']='Muller';//сделать рандом из базы имен
        
        $querys['team_num']=1;//нужна ф-ия определения последнего использованного номера в команде
        
        $querys['phys_energy']=rand(1, 99);
        $querys['phys_strength']=rand(1, 99);
        $querys['phys_endurance']=rand(1, 99);
        $querys['shoot_technique']=rand(1, 99);
        $querys['shoot_calm']=rand(1, 99);
        $querys['shoot_accuracy']	=rand(1, 99);
        $querys['track_technique']=rand(1, 99);
        
        $querys['track_speed']=rand(15, 17);//для нубов скорость 15
        
        $querys['popularity']=rand(0, 10);
        
        $querys['overall_rating']=$querys['phys_energy']+$querys['phys_strength']+$querys['phys_endurance']+$querys['shoot_technique']+$querys['shoot_calm']+$querys['shoot_accuracy']+$querys['track_technique'];

        
        foreach($querys as $field=>$value)
        {
        $fields[]="`".$field."`";
        $values[]="'".$value."'";
        }
        
        $fields=implode(', ',$fields);
        $values=implode(', ',$values);
        
        $query="INSERT INTO `rsm_biatloner` (".$fields.") VALUES (".$values.")";
        //$this->db->query($query);
        print($query);
        
        print_r($_SERVER);
        //return $query->result();
    }
        

    function edit_biatloner($data) {
    
        if (isset($data['b_id'])) $b_id=mysql_real_escape_string($data['b_id']);

        foreach($data as $field=>$value)
        {
                if (isset($data[$field])) {
                        $fields[]="`".$field."`";
                        $values[]=mysql_real_escape_string("'".$value."'");
                        $fieldvalues[]="`{$field}`='{$value}'";
                }
        }
        
        $fields=implode(', ',$fields);
        $values=implode(', ',$values);
        $fieldvalues=implode(', ',$fieldvalues);
        
        $query="UPDATE `rsm_biatloner` SET ".$fieldvalues." WHERE `b_id` = $b_id";       
        $this->db->query($query);
    }
}
?>