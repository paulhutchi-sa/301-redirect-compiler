<?php


// 1st section
// in section 1, open those 2 file and put the content in an array $awards[] and $contracts[], so $awards[0] is the first line in awards.csv, $awards[1] is the second line in awards.csv, etc, the same in $contracts[].

        $oldw = fopen('oldwebscan.csv', 'r');
        $neww = fopen('newwebscan.csv', 'r');
         while (($data = fgetcsv($oldw, 0, ",")) !== FALSE) {
            $oldwebscan[]=$data;
        }
        while (($data = fgetcsv($neww, 0, ",")) !== FALSE) {
                $newwebscan[]=$data;
        }
// 2nd section
// i compare the first word in every array, $awards[x][0] and $contracts[x][0].
// the first if, if($x==0), is to make the header. first, i delete the first word contractname using unset function and join $awards[0] and $contracts[0] using array_merge function.
// then, using those for i select the first word in every line from $contracts array and compare with the first word from every line from $awards array. so, if($awards[$y][0] == $contracts[$x][0]) check if those first word (ej. Contract-2070-3are) are the same, if those are the same string, delete it and merge those lines.
// if those word arent the same, save the $contracts[x] line in $line array and continue.

        for($x=0;$x< count($newwebscan);$x++)
        {
            if($x==0){
                unset($oldwebscan[0][0]);
                $line[$x]=array_merge($newwebscan[0],$oldwebscan[0]); //header
            }
            else{
                $deadlook=0;
                for($y=0;$y <= count($oldwebscan);$y++)
                {
                    if($oldwebscan[$y][0] == $newwebscan[$x][0]){
                        unset($oldwebscan[$y][0]);
                        $line[$x]=array_merge($newwebscan[$x],$oldwebscan[$y]);
                        $deadlook=1;
                    }           
                }
                if($deadlook==0)
                    $line[$x]=$newwebscan[$x];
            }
        }
// 3 section
// in section 3, save the content from $line array in the file.  
        $fp = fopen('final.csv', 'w');//output file set here

        foreach ($line as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);


?>