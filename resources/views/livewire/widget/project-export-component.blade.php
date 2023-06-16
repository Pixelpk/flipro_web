
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link
      href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,300;0,400;1,300;1,400;1,500&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
      rel="stylesheet"
    />
    <!-- Latest compiled and minified CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="./style.css" />
    <title> {{ $project->title }}</title>
  </head>
  <body>
    
    <div class="main">
      <div class="container info-txt">
        <h1 class=""> {{ $project->title }}</h1>
        <div class="container row mt-3">
          <div class="col-md-4">
            <h4 class="my-4">Applicant Information</h4>
            <b> </b>
            <p><b>Created date: </b>  {{ date('d-m-Y', strtotime($project->created_at)) }}</p>
            <p><b>Project Status:</b> 
                @if ($project->approved == 'rejected')
             
                     Rejected
               
            @endif
            @if ($project->approved == 'approved')
                
                     {{ ucfirst($project->status) }}
             
            @endif
            
            </p>
            <p><b>Applicant Name:</b> {{ $project->applicant_name }}</p>
            <p><b>Applicant Email:</b> {{ $project->email }}</p>
            <p><b>Applicant Phone:</b> {{  $project->phone_code . ' ' . chunk_split($project->phone, 3, ' ')}}</p>
            <p><b>Register Owner:</b> {{ $project->registered_owners }}</p>
          </div>
          <div class="col-md-4">
            <h4 class="my-4">Project Information</h4>
            <p><b>Project Address: </b> {{ $project->title }}</p>
            <p><b>Area (Square Meters): </b>  {{ number_format((float) $project->area) }}</p>
            <p><b>Anticipated Budget:</b>  ${{ number_format((float) $project->anticipated_budget) }}</p>
            <p><b>Applicant Address: </b>  {{ $project->applicant_address }}</p>
            <p><b>Suburb, State and postal Code :</b>   {{ $project->project_state }}</p>
            <p><b>Existing Queries: </b>
                @if ($project->contractor_supplier_details == 1)
                Yes
                @else
                    No
                @endif
            </p>
            <p><b>Description: </b>    {{ $project->description }}</p>
          </div>
          <div class="col-md-4">
            <h4 class="my-4">Financials</h4>
            <p><b>Current Value: </b>   ${{ number_format((float) $project->current_property_value) }}</p>
            <p><b>Property Debts:</b>   ${{ number_format((float) $project->property_debt) }}</p>
            <p><b>Cross Collaterized: </b> 
                @if ($project->cross_collaterized == 1)
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
            </p>
          </div>
        </div>
        <div class="col-md-6"></div>
      </div>

      <div class="container my-4">
        <h4 class="my-3 text-center">Teams</h4>

        <div>
          <section class="container scroll">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Roles</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>Manejaar</td>
                </tr>
              </tbody>
            </table>
          </section>
        </div>
      </div>

      <div class="container my-4">
        <div>
          <div class="d-flex">
            <h4 class="mx-4">Tasks</h4>
          </div>

          <section class="container scroll">
            <table class="table table-striped">
                <tr>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Scheduled Date</th>
                    <th>Project</th>
                    <th>Created By</th>
                    <th>Action Taken</th>
                    <th>Status</th>
                  
                </tr>
                @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ \Carbon\Carbon::create($task->event_date)->format('d-m-Y h:i
                                                                            a') }}
                    </td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $task->createdBy->name ?? '' }}</td>
                    <td>
                        {{ $task->action_taken }}
                    </td>
                    <td>
                        {{ $task->status }}
                    </td>
                   
                </tr>
                @endforeach
            </table>
          </section>
        </div>
      </div>

      <div class="container my-4">
        <div>
          <div class="d-flex align-items-center justify-content-center">
            <h4 class="mx-4">Price Evaluations</h4>
          </div>

          <section class="container scroll">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Roles</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>Manejaar</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>Manejaar</td>
                </tr>
              </tbody>
            </table>
          </section>
        </div>
      </div>

      <div class="container my-4">
        <div>
          <div class="d-flex align-items-center justify-content-center">
            <h4 class="mx-4">Activity Timeline</h4>
          </div>
          <section class="container scroll">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Larry</td>
                  <td>the Bird</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
              </tbody>
            </table>
          </section>
        </div>
      </div>

      <div class="container my-4">
        <div>
          <div class="d-flex align-items-center justify-content-center">
            <h4 class="mx-4">Notes</h4>
          </div>
          <section class="container scroll">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Larry</td>
                  <td>the Bird</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
              </tbody>
            </table>
          </section>
        </div>
      </div>

      <div class="container my-4">
        <div>
          <div class="d-flex align-items-center justify-content-center">
            <h4 class="mx-4">Contracts</h4>
          </div>

          <section class="container scroll">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Larry</td>
                  <td>the Bird</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                </tr>
              </tbody>
            </table>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
