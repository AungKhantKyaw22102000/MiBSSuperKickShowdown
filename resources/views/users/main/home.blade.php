@extends('users.layouts.master')

@section('title', 'Home')

@section('content')
    <!-- standing -->
    <div class="standing segments-page">
        <div class="container"><br>
            <div class="button-container">
                <a href="schedule.php" class="custom-button" style="--clr:#BC13FE"><span>Schedule</span><i></i></a>
                <a href="stats.php" class="custom-button" style="--clr:#FFF01F"><span>Statistics</span><i></i></a>
                <a href="results.php" class="custom-button" style="--clr:#39FF14"><span>Result</span><i></i></a>
                <a href="players.php" class="custom-button" style="--clr:#FF3131"><span>Player</span><i></i></a>
                <a href="gallery.php" class="custom-button" style="--clr:#EA00FF"><span>Gallery</span><i></i></a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="custom-th">Pos</th>
                        <th>Club</th>
                        <th>PL</th>
                        <th>W</th>
                        <th>D</th>
                        <th>L</th>
                        <th>GF</th>
                        <th>GA</th>
                        <th>GD</th>
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class='$rowClass'>
                        <td>" . $i++ . "</td>
                        <td><a href='club-details.php?viewteam=" . $id ."'><img src='photo/'
                                    style='width: 20px; height: 20px;'></a></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class='btn-group'>
                                <a class='' href='update_team.php?update=" . $id ."'>
                                    <i class='fa-solid fa-pen-to-square' title='Update'></i>
                                </a>
                                <a class='' href='standing.php?delete="  . $id . "'>
                                    <i class='fa-solid fa-trash-can' title='Delete'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- end standing -->
@endsection
