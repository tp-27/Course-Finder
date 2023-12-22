    <?php 
        $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        session_start();
        
        function resetGame(){
            $board = [
                ['-','-','-'],
                ['-','-','-'],
                ['-','-','-']
            ];
            $_SESSION['board'] = $board;
            $_SESSION['numMoves'] = 0;
            $_SESSION['gameOver'] = null;
            $_SESSION['showImage'] = TRUE;
        }
        
        function checkWin($board, $piece){
            //check columns and rows
            for($i = 0; $i < 3; $i++){
                //check columns
                if($board[$i][0] == $piece && $board[$i][1] == $piece && $board[$i][2] == $piece){
                    return TRUE;
                }
                //check rows
                elseif($board[0][$i] == $piece && $board[1][$i] == $piece && $board[2][$i] == $piece){
                    return TRUE;
                }
            }
            //check diagonals
            if($board[0][0] == $piece && $board[1][1] == $piece && $board[2][2] == $piece){
                return TRUE;
            }
            elseif($board[0][2] == $piece && $board[1][1] == $piece && $board[2][0] == $piece){
                return TRUE;
            }
            return FALSE;
        }
        
        if (isset($_POST["reset"])) {
            resetGame();
        }

        $showImage = isset($_SESSION['showImage']) ? $_SESSION['showImage']: TRUE;

        $gameOver = isset($_SESSION['gameOver']) ? $_SESSION['gameOver'] : null;

        if (isset($_POST["closeImage"])) {
            $_SESSION['showImage'] = FALSE;
            $showImage = FALSE;
        }

        $board = isset($_SESSION['board']) ? $_SESSION['board'] : [
            ['-','-','-'],
            ['-','-','-'],
            ['-','-','-']
        ];

        $numMoves = isset($_SESSION['numMoves']) ?  $_SESSION['numMoves'] : 0;

        if (isset($_POST["row"]) && isset($_POST["col"])) {
            $row = $_POST["row"];
            $col = $_POST["col"];
            
            if($gameOver == '-'){
                $output = "Game is over please click restart!";
            }
            elseif($board[$row][$col] == '-'){
                $board[$row][$col] = 'X';
                $_SESSION['board'] = $board;
                $numMoves++;
                $_SESSION['numMoves'] = $numMoves;
                if(checkWin($board, 'X')){
                    $gameOver = '-';
                    $_SESSION['gameOver'] = $gameOver;
                    $output = "You won!";
                }
                elseif($numMoves == 9){
                    $gameOver = '-';
                    $_SESSION['gameOver'] = $gameOver;
                    $output = "It's a draw!";
                }
                else{
                    while(TRUE){
                        $botRow = rand(0,2);
                        $botCol = rand(0,2);
                        if($board[$botRow][$botCol] == '-'){
                            $board[$botRow][$botCol] = 'O';
                            $_SESSION['board'] = $board;
                            $numMoves++;
                            $_SESSION['numMoves'] = $numMoves;
                            if(checkWin($board, 'O')){
                                $gameOver = '-';
                                $_SESSION['gameOver'] = $gameOver;
                                $output = "You lost!";
                            }
                            break;
                        }
                    }
                }

            }
            else{
                $output = "That place is taken";
            }
            
        }

    ?>
<html>
<head>
    <title>John Constantinides</title>
    <a class="link" href=<?php echo str_replace("Team104/john/", "", $url) ?>><h1 class="logo">104</h1></a>
</head>
<body>
<link rel="stylesheet" type="text/css" href="styles.css">
    <div class="profile">
        <img src = "john.jpg" alt="Picture of John" />
        <div class="intro">
            <h2>Hello, my name is John</h2>
        </div>
        <p>I am a fourth-year Computer Science student at the University of Guelph. I chose Computer Science because
            it seemed pretty cool imo. I will be graduating around April 2025 unless I somehow fail a bunch of classes. I like
            to watch sports, play video games, watch TV shows and movies.
        </p>

    </div>

    <div class="tictactoe">
        <h2>TicTacToe</h2>
        <p>Here is a TicTacToe game. You start every time and will be X. Click on the tile where you want to place your 
            piece. Your opponent isn't very smart and places pieces randomly, so if you lose then that would be pretty 
            embarrassing.
        </p>
        <?php if (isset($output)) : ?>
            <p><?php echo $output; ?></p>
        <?php endif; ?>
        <div>
            <table>
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <tr>
                        <?php for ($j = 0; $j < 3; $j++): ?>
                            <td>
                                <form method="post" id="board" role="form">
                                    <input type="hidden" name="row" value="<?php echo $i; ?>">
                                    <input type="hidden" name="col" value="<?php echo $j; ?>">
                                    <button type="submit"><?php echo $board[$i][$j]; ?></button>
                                </form>
                        </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>

        <form method="post">
            <input type="hidden" name="reset" value="1">
            <button type="submit">Reset</button>
        </form>
    </div>
    
    <?php if($showImage) : ?>
        <div id="subwaysurfers">
            <form method="post">
                <input type="hidden" name="closeImage">
                <button type="submit">X</button>
            </form>
            <img src="subwaysurfers.gif" alt="Subway Surfers" />
        </div>
    <?php endif; ?>        

</body>
</html>