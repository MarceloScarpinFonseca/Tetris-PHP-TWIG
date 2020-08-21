<?php


class TetrisController {
    public function index() {
        if(!isset($_SESSION)){
            session_start();
        }
        for ($index = 0; $index < 30; $index++) {
            for ($index1 = 0; $index1 < 30; $index1++){
                $b[$index][$index1] = array('fixo' => false, 'valor' => null, 'r' => false);
            }
        }
        $b = $this->novoBloco($b);      
        $this->setFile($b);
        $estado = 'jogando';
        $this->render($estado);
    }
    public function play() {
        if(!isset($_SESSION)){
            session_start();
        }
        if (isset($_GET['direcao'])){
        $direcao = $_GET['direcao'];            
        }else{
            $direcao = 'n';
        }
        $b = $this->getFile();
        $matrizAntiga = $b;    
        $matrizNula = array(array());
        for ($index = 0; $index < 30; $index++) {
            for ($index1 = 0; $index1 < 30; $index1++){
                $matrizNula[$index][$index1] = array('fixo' => false, 'valor' => null, 'r' => false);
            }
        }
        $b = $matrizNula;
          
        $bloqueado = 'n';
        $ultimaLinha = 0;
        for ($index5 = 0; $index5 < 30; $index5++) {
            if ($matrizAntiga[29][$index5]['valor'] != null){
                $ultimaLinha++;
            }
        }
        if ($ultimaLinha == 30){
                $matrizAntiga = $this->ultimaLinha($matrizAntiga);
                $b = $this->novoBloco($b); 
            }
        for ($borda = 0; $borda < 30; $borda++) {
                    if ($matrizAntiga[$borda][0]['valor'] != null && $matrizAntiga[$borda][0]['fixo'] == false){
                        $bloqueado = 'e';
                    }
                    if ($matrizAntiga[$borda][29]['valor'] != null && $matrizAntiga[$borda][29]['fixo'] == false){
                        $bloqueado = 'd';
                    }
                    if ($matrizAntiga[29][$borda]['valor'] != null && $matrizAntiga[29][$borda]['fixo'] == false){
                        for ($index2 = 0; $index2 < 30; $index2++) {
                            for ($index3 = 0; $index3 < 30; $index3++) {
                                if ($matrizAntiga[$index2][$index3]['valor'] != null){
                                    $matrizAntiga[$index2][$index3]['fixo'] = true;
                                }
                            }
                        }
                        $b = $this->novoBloco($b); 
                    }else{
                        for ($index4 = 0; $index4 < 30; $index4++) {
                            $bordaMais = $borda + 1;
                            $h = $index4;
                            $hMais = $index4 + 1;
                            $hMenos = $index4 - 1;
                            if ($bordaMais == 30){
                                
                            }else if ($matrizAntiga[$borda][$index4]['valor'] != null && $matrizAntiga[$bordaMais][$index4]['fixo'] == true && $matrizAntiga[$borda][$index4]['fixo'] == false){
                                for ($index2 = 0; $index2 < 30; $index2++) {
                                    for ($index3 = 0; $index3 < 30; $index3++) {
                                        if ($matrizAntiga[$index2][$index3]['valor'] != null){
                                            $matrizAntiga[$index2][$index3]['fixo'] = true;
                                        }
                                    }
                                }
                                $b = $this->novoBloco($b); 
                            }
                            if ($hMais == 30){
                                
                            }else if($matrizAntiga[$borda][$index4]['valor'] != null && $matrizAntiga[$borda][$hMais]['fixo'] == true && $matrizAntiga[$borda][$index4]['fixo'] == false){
                                $bloqueado = 'd';
                            }if ($hMenos == 1){
                                
                            }else if($matrizAntiga[$borda][$index4]['valor'] != null && $matrizAntiga[$borda][$hMenos]['fixo'] == true && $matrizAntiga[$borda][$index4]['fixo'] == false){
                                $bloqueado = 'e';
                            }
                        }
                    }
        }
        switch ($direcao) {
            case 'e':
                if ($bloqueado != 'e'){
                    for ($horizontal = 0; $horizontal < 30; $horizontal++) {
                        for ($vertical = 0; $vertical < 30; $vertical++) {
                            if ($matrizAntiga[$horizontal][$vertical]['fixo'] == true){
                                $h = $vertical;
                                $v = $horizontal;
                                $b[$v][$h] = $matrizAntiga[$horizontal][$vertical];
                            }else if($matrizAntiga[$horizontal][$vertical]['valor'] != null){
                                $h = $vertical - 1;
                                $v = $horizontal;
                                $b[$v][$h] = $matrizAntiga[$horizontal][$vertical];
                            }
                        }
                    }
                }else{
                    $b = $matrizAntiga;
                }
                break;
            case 'd':
                if ($bloqueado != 'd'){
                    for ($horizontal = 0; $horizontal < 30; $horizontal++) {
                        for ($vertical = 0; $vertical < 30; $vertical++) {
                            if ($matrizAntiga[$horizontal][$vertical]['fixo'] == true){
                                $h = $vertical;
                                $v = $horizontal;
                                $b[$v][$h] = $matrizAntiga[$horizontal][$vertical];
                            }else if($matrizAntiga[$horizontal][$vertical]['valor'] != null){
                                $h = $vertical + 1;
                                $v = $horizontal;
                                $b[$v][$h] = $matrizAntiga[$horizontal][$vertical];
                            }
                        }
                    }
                }else{
                    $b = $matrizAntiga;
                    
                }
                break;
            case 'b':
                for ($horizontal = 0; $horizontal < 30; $horizontal++) {
                    for ($vertical = 0; $vertical < 30; $vertical++) {
                        if ($matrizAntiga[$horizontal][$vertical]['fixo'] == true){
                            $h = $vertical;
                            $v = $horizontal;
                            $b[$v][$h] = $matrizAntiga[$horizontal][$vertical];
                        }else if($matrizAntiga[$horizontal][$vertical]['valor'] != null){
                            $h = $vertical;
                            $v = $horizontal + 1;
                            $b[$v][$h] = $matrizAntiga[$horizontal][$vertical];
                        }
                    }
                }
                break;
            case 'h':
                if ($bloqueado == 'n'){
                    $b = $this->rotacionarBloco($matrizAntiga);
                } else {
                    $b = $matrizAntiga;
                }
                    break;
            case 'a':
                if ($bloqueado == 'n'){
                    $b = $this->rotacionarBloco($matrizAntiga);
                    $matrizAntiga = $this->rotacionarBloco($b);
                    $b = $this->rotacionarBloco($matrizAntiga);  
                } else {
                    $b = $matrizAntiga;
                }
                break;
            case 'n':
                    $b = $matrizAntiga;
                break;
        }
        $estado = 'jogando';
        $this->setFile($b);
        $this->render($estado);
    }
    public function novoBloco($b) {
        $bloco = $this->bloco();
        $cont = 0;
        for ($index = 0; $index < 3 ; $index++) {
            for ($index1 = 13; $index1 < 16; $index1++) {
                $b[$index][$index1] = $bloco[$cont];
                $cont++;
            }
        }
        return $b;
    }
    public function bloco() {
        $array = array();
        $rand1 = rand(1, 7);
        $a = array('fixo' => false, 'valor' => $rand1, 'r' => false);
        $na = array('fixo' => false, 'valor' => $rand1, 'r' => true);
        $b = array('fixo' => false, 'valor' => null, 'r' => false);
        $nb = array('fixo' => false, 'valor' => null, 'r' => true);
        $n = mt_rand(1, 5);
        switch ($n){
            case 1:
                $array = array(  $b,   $b,   $b,
                                 $b,   $na,  $a,
                                 $b,   $a,   $a);
                break;
            case 2:
                $array = array(  $b,   $b,   $b,
                                 $a,   $na,  $a,
                                 $b,   $b,   $b);
                break;
            case 3:
                $array = array(  $b,   $a,   $b,
                                 $a,   $na,  $a,
                                 $b,   $b,   $b);
                break;
            case 4:
                $array = array(  $b,   $b,   $b,
                                 $a,   $na,  $a,
                                 $b,   $b,   $a);
                break;
            case 5:
                $array = array(  $b,   $b,   $b,
                                 $b,   $na,  $a,
                                 $a,   $a,   $b,);
                break;
        }
        $nn = rand(1, 4);
        switch ($nn){
            case 1:
                return $array;
                break;
            case 2:
                return $this->rotacionar($array);
                break;
            case 3:
                $array = $this->rotacionar($array);
                $array = $this->rotacionar($array);
                return $array;
                break;
            case 4:
                $array = $this->rotacionar($array);                
                $array = $this->rotacionar($array);                
                $array = $this->rotacionar($array);
                return $array;
                break;
        }
    }
    public function rotacionarBloco($b) {
        $bAntiga = $b;
        $matrizNula = array(array());
        $array = array();
        for ($index3 = 0; $index3 < 30; $index3++) {
            for ($index4 = 0; $index4 < 30; $index4++) {
                 $matrizNula[$index3][$index4] = array('fixo' => false, 'valor' => null, 'r' => false);
            }
        }
        $b = $matrizNula;
        $cont = 0;
        for ($index = 0; $index < 30; $index++) {
            for ($index1 = 0; $index1 < 30; $index1++){
                $h = $index;
                $v = $index1;
                if ($bAntiga[$index][$index1]['valor'] != null && $bAntiga[$index][$index1]['fixo'] == true){
                    $b[$h][$v] = $bAntiga[$h][$v];
                }
                if ($bAntiga[$index][$index1]['r'] == true && $bAntiga[$index][$index1]['fixo'] == false){
                    $iMais = $index + 1;
                    $iMenos = $index - 1;
                    $iiMais = $index1 + 1;
                    $iiMenos = $index1 - 1;
                    for ($h = $iMenos; $h <= $iMais; $h++) {
                        //echo 'oi ';
                        for ($v = $iiMenos; $v <= $iiMais; $v++) {
                            $array[] = $bAntiga[$h][$v];
                        }
                    }
                    $array = $this->rotacionar($array); 
                    for ($h = $iMenos; $h <= $iMais; $h++) {
                        for ($v = $iiMenos; $v <= $iiMais; $v++) {
                            $b[$h][$v] = $array[$cont];
                            $cont++;
                        }
                    }
                }
                
            }
        }
        return $b;
    }
    public function rotacionar($array) {
            $n = array();
            $n[0] = $array[6];
            $n[1] = $array[3];
            $n[2] = $array[0];
            $n[3] = $array[7];
            $n[4] = $array[4];
            $n[5] = $array[1];
            $n[6] = $array[8];
            $n[7] = $array[5];
            $n[8] = $array[2];
            return $n;
    }
    private function ultimaLinha($b) {
        $matrizAntiga = $b;
        $matrizNula = array(array());
        $array = array();
        for ($index3 = 0; $index3 < 30; $index3++) {
            for ($index4 = 0; $index4 < 30; $index4++) {
                 $matrizNula[$index3][$index4] = array('fixo' => false, 'valor' => null, 'r' => false);
            }
        }
        $b = $matrizNula;
        for ($index = 0; $index < 30; $index++) {
            $matrizAntiga[29][$index] = array('fixo' => false, 'valor' => null, 'r' => false);
        }
        for ($horizontal = 0; $horizontal < 30; $horizontal++) {
                        for ($vertical = 0; $vertical < 30; $vertical++) {
                            if($matrizAntiga[$horizontal][$vertical]['valor'] != null){
                                $h = $vertical;
                                $v = $horizontal + 1;
                                $b[$v][$h] = $matrizAntiga[$horizontal][$vertical];
                            }
                        }
                    }
        return $b;
    }
    public function getFile() {
        $conteudo = $_SESSION['conteudo'];
        return $conteudo;
    }
    public function setFile($b) {
        $_SESSION['conteudo'] = $b;
    }
    public function render($estado) {
        $b = $this->getFile();
        $m = array(array());
        for ($ih = 0; $ih < 30; $ih++) {
            for ($iv = 0; $iv < 30; $iv++) {
                if ($b[$ih][$iv]['valor'] != null){
                    $m[$ih][$iv] = $b[$ih][$iv]['valor'];
                }else{
                    $m[$ih][$iv] = 0;
                }
            }
        }
        $loader = new \Twig\Loader\FilesystemLoader('app/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('tetris.html');
        $parametros = array();
        switch ($estado){
            case 'jogando':
                $amarelo = '/Tetris/app/imgs/amarelo.png';
                $azul = '/Tetris/app/imgs/azul.png';
                $branco = '/Tetris/app/imgs/branco.png';
                $laranja = '/Tetris/app/imgs/laranja.png';                
                $preto = '/Tetris/app/imgs/preto.png';
                $roxo = '/Tetris/app/imgs/roxo.png';
                $verde = '/Tetris/app/imgs/verde.png';
                $vermelho = '/Tetris/app/imgs/vermelho.png';
                $v = array();
                for ($index3 = 0; $index3 < 30; $index3++) {
                    for ($index4 = 0; $index4 < 30; $index4++) {
                        $v[] = $m[$index3][$index4];
                    }
                }
                for ($index2 = 0; $index2 < 900; $index2++) {
                    switch ($v[$index2]){
                        case 0:
                            $img = $preto;
                            break;
                        case 1:
                            $img = $verde;
                            break;   
                        case 2:
                            $img = $laranja;
                            break;
                        case 3:
                            $img = $amarelo;
                            break;
                        case 4:
                            $img = $roxo;
                            break;
                        case 5:
                            $img = $azul;
                            break;
                        case 6:
                            $img = $branco;
                            break;
                        case 7:
                            $img = $vermelho;
                            break;
                    }
                    $parametros['a'.$index2] = $img;
                }
                break;
            case 'ganhou':
                $parametros['frase'] = 'Parabéns vc ganhou!!!';
                $parametros['qtd'] = $s[0]['qtd'].'m';
                break;
            case 'perdeu':
                $parametros['frase'] = 'Que pena vc perdeu o jogo';
                $parametros['qtd'] = $s[0]['qtd'].'m';
                break;
        }
        $conteudo = $template->render($parametros);
        echo $conteudo;      
    }
}
