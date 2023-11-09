<?php
  require("koneksi.php"); // memanggil file koneksi.php untuk koneksi ke database
?>

<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="refresh" content="10">
  <!-- Sisipkan skrip Chart.js dari CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  </head>
    <body>
      <!-- Elemen <canvas> untuk menampilkan grafik -->
    <canvas id="myChart" height="50"></canvas>

      <style>
        #wntable {
          border-collapse: collapse;
          width: 50%;
        }

        #wntable td, #wntable th {
          border: 1px solid #ddd;
          padding: 8px;
        }

        #wntable tr:nth-child(even){background-color: #f2f2f2;}

        #wntable tr:hover {background-color: #ddd;}

        #wntable th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #00A8A9;
          color: white;
        }
      </style>

      <div id="cards" class="cards" align="center">
          <h1> Data Sensor Metana</h1>
          <table id="wntable">
          <tr>
            <th>No</th>
            <th>Data</th>
            <th>Waktu</th>
          </tr>
          <?php

          $sql = mysqli_query($koneksi, "SELECT * FROM datasensor ORDER BY id DESC");

          if(mysqli_num_rows($sql) == 0){ 
            echo '<tr><td colspan="14">Data Tidak Ada.</td></tr>'; // jika tidak ada entri di database maka tampilkan 'Data Tidak Ada.'
          }else{ // jika terdapat entri maka tampilkan datanya
            $no = 1; // mewakili data dari nomor 1
            while($row = mysqli_fetch_assoc($sql)){ // fetch query yang sesuai ke dalam array
              echo '
              <tr>
                <td>'.$no.'</td>
                <td>'.$row['data'].'</td>
                <td>'.$row['waktu'].'</td>
              </tr>
              ';
              $no++; // mewakili data kedua dan seterusnya
            }
          }
          ?>
        </table>
      </div>
  </body>
  <script type="text/javascript">
    // Inisialisasi grafik menggunakan Chart.js
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'line', // atau jenis grafik lainnya seperti line, pie, dll.
      data: {
        labels: ['Waktu'], // label sumbu x
        datasets: [{
            label: 'Grafik Sensor Metana', // label dataset
            data: [12, 19, 3, 5, 2, 3], // data sumbu y
            backgroundColor: 'rgba(255, 99, 132, 0.2)', // warna latar belakang dataset
            borderColor: 'rgba(255, 99, 132, 1)', // warna batas dataset
            borderWidth: 1 // lebar batas
        }]
      },
    options: {
        scales: {
            y: {
                beginAtZero: true // nilai minimum pada sumbu y
            }
        }
    }
    });

    function fetchData() {
        fetch('real_time_data.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(item => {
                    chart.data.labels.push(item.waktu);
                    chart.data.datasets[0].data.push(item.data);
                    value = item.alert;
                });
                chart.update();
                if(value == 1){
                alert('gas metana melebihi batas aman');
                }
            });
    }

    // Memanggil fungsi fetchData setiap beberapa detik
    fetchData();
  </script>
</html>