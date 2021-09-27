<?php
if (!function_exists('is_super_admin')) {
    function is_super_admin($id)
    {
        return (int)$id == 1 ? true : false;
    }
}


function getSqlLog()
{
    //    if (\Illuminate\Support\Facades\App::environment() != 'local') return true;

    \Illuminate\Support\Facades\DB::listen(function ($sql) {
        foreach ($sql->bindings as $i => $binding) {
            if ($binding instanceof \DateTime) {
                $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            } else {
                if (is_string($binding)) {
                    $sql->bindings[$i] = "'$binding'";
                }
            }
        }        // Insert bindings into query
        $query = str_replace(['%', '?'], ['%%', '%s'], $sql->sql);
        $query = vsprintf($query, $sql->bindings);        // Save the query to file
        $logFile = fopen(
            storage_path('logs' . DIRECTORY_SEPARATOR . 'query.log'),
            'a+'
        );
        fwrite($logFile, date('Y-m-d H:i:s') . ': ' . $query . PHP_EOL);
        fclose($logFile);
    });

    return true;
}

function dda($model)
{
    if (method_exists($model, 'toArray')) {
        dd($model->toArray());
    } else {
        dd($model);
    }
}
