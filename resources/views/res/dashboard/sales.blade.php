@extends('layouts.resmain')

@section('content')
 <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Sales <i class="material-icons">arrow_forward_ios</i></span> Sales Dashboard</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m3 l3">
      <div class="card">
        <div class="card-content">
          <span class="card-title"><strong>{{date('Y')}}</strong> Sales Hit Rate</span>
          <h2 class="center green white-text" style="padding: 10px 0px;border-radius:50px;">100%</h2>
        </div>
      </div>
    </div>
    <div class="col s12 m4 l4">
      <div class="card">
        <div class="card-content">
          <span class="card-title"><strong>{{date('Y')}}</strong> Quarterly Hit Rate</span>
          <h2 class="center green white-text" style="padding: 10px 0px;border-radius:50px;">100%</h2>
        </div>
      </div>
    </div>
    <div class="col s12 m5 l5">
      <div class="card">
        <div class="card-content"  style="height:200px">
            <span class="card-title">Business Unit Performance</span>
        </div>
      </div>
    </div>
 </div>
  <div class="row main-content">
    <div class="col s12 m6 l6">
      <div class="card">
        <div class="card-content">
            <span class="card-title">Monthly Sales</span>
            <canvas id="monthlyChart" ></canvas>
        </div>
      </div>
    </div>
    <div class="col s12 m6 l6">
      <div class="card">
        <div class="card-content"  style="height:300px">
          <span class="card-title">Sales Rep. Performance</span>
          @foreach ($salesrep as $rep)
            <div class="chip {{ $rep->site_code == 'RSA' ? 'blue' : 'red'}} darken-3 white-text z-depth-1" style="margin-top: 20px;">
              <img src="/{{$rep->emp_photo}}" alt="Contact Person" class="white">
              {{$rep->emp_fname}}
            </div>
          @endforeach
        </div>
      </div>
    </div>
 </div>
  <div class="row main-content">
    <div class="col s12 m6 l8">
      <div class="card">
        <div class="card-content"  style="height:300px">
          <span class="card-title">Area Visitation</span>
        </div>
      </div>
    </div>
    <div class="col s12 m6 l4">
      <div class="card">
        <div class="card-content"  style="height:300px">
          <span class="card-title">YTD Sales</span>
        </div>
      </div>
    </div>
 </div>
 <script>
    var monthlyChart = document.getElementById('monthlyChart').getContext('2d');
    var monthlyChartData = new Chart(monthlyChart, {
        type: 'bar',
        data: {
            datasets: [{
                label: 'Actual Sales',
                borderColor: '#af560e',
                backgroundColor: 'rgba(226, 112, 18, 0.78)',
                data: [10, 20, 30, 40]
            }, {
                label: 'Target',
                type: 'line',
                fill: false,
                backgroundColor: 'green',
                borderColor: ['#4CAF50'],
                data: [50, 50, 50, 50],
            }],
            labels: ['January', 'February', 'March', 'April']
        },
        options: { 
				  responsive: true,
                  scales :{"yAxes":[{"ticks":{"beginAtZero":true}}]},
                  legend:{'position':'right'}
                 }
    });

    
 </script>
@endsection
