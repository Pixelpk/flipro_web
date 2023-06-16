<style>
  .image-gallery {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
  }

  .image-gallery img {
      width: calc(100% / 3); /* Adjust the value as needed */
      height: auto;
      object-fit: cover;
      object-position: center;
      margin: 5px;
  }
</style>
<div class="app-content content">
      <div class="content-wrapper">
          <div class="row">
              <div class="col-xl-12">

                  <div class="nav-align-top mb-4">
                      {{-- <ul class="nav nav-tabs" role="tablist">
                          <li class="nav-item" role="presentation">
                              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                  data-bs-target="#navs-top-home" aria-controls="navs-top-home"
                                  aria-selected="true">Photo</button>
                          </li>
                          <li class="nav-item" role="presentation">
                              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                  data-bs-target="#navs-top-profile" aria-controls="navs-top-profile"
                                  aria-selected="false" tabindex="-1">Video</button>
                          </li>
                      </ul> --}}
                      <div class="tab-content">
                          <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                              <!-- Modal gallery -->
                              <section class="">
                                  <!-- Section: Images -->
                                  <section class="">
                                      <div class="row container">
                                          <div class="col-md-12 py-2">
                                              <h3 class="display-4" style="font-size: 25px;font-weight: 700;">Project
                                              </h3>
                                          </div>
                                          <div class="col-md-12 mb-2">
                                              <h3 class="display-8" style="font-weight: 700;">Photos
                                              </h3>
                                          </div>
                                          @foreach ((array) $project->photos as $image)
                                          @php
                                          $photo = $image;
                                          if ($photo) {
                                          if (filter_var($photo, FILTER_VALIDATE_URL)) {
                                          $photo = explode('/', $photo);
                                          $photo = $photo[count($photo) - 2] . '/' . $photo[count($photo) - 1];
                                          }
                                          }
                                          @endphp

                                          <div class="col-md-2 mb-2">
                                              <a target="_blank" href="/stream/{{ $photo }}">
                                                  <img src="/stream/{{ $photo }}" class="img-fluid" alt="Project Photo">
                                              </a>
                                          </div>
                                          @endforeach
                                      </div>
                                      <div class="row">
                                          <div class="col-md-12 py-2">
                                              <h3 class="display-8" style="font-weight: 700;">Videos
                                              </h3>
                                          </div>
                                          @isset($project->videos)
                                            
                                          
                                          @if ((array) $project->videos)
                                          
                                          @foreach ((array) $project->videos as $video)
                                          <div class="col-md-2 mb-2">
                                              <video src="{{ $video['file'] }}" width="100%" controls="true"
                                                  autoplay="false">
                                                  <source src="{{ $video['file'] }}">
                                              </video>
                                          </div>
                                          @endforeach

                                          @endif
                                          @endisset
                                      </div>
                                      <br>
                                      <hr>
                                      <div class="row">
                                          <div class="col-md-12 py-2">
                                              <h3 class="display-4" style="font-size: 25px;font-weight: 700;">Progress
                                                  Timeline
                                              </h3>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-12 mb-2">
                                              <h3 class="display-8" style="font-weight: 700;">Photos
                                              </h3>
                                          </div>
                                          @foreach ($timeLine as $item)
                                          @if(isset($item->photos))
                                          @foreach ((array) $item->photos as $image)
                                          @php
                                          $photo = $image;
                                          if ($photo) {
                                          if (filter_var($photo, FILTER_VALIDATE_URL)) {
                                          $photo = explode('/', $photo);
                                          $photo = $photo[count($photo) - 2] . '/' . $photo[count($photo) - 1];
                                          }
                                          }
                                          @endphp

                                          <div class="col-md-2 mb-2">
                                              <a target="_blank" href="/stream/{{ $photo }}">
                                                  <img src="/stream/{{ $photo }}" width="100%" alt="Project Photo">
                                              </a>
                                          </div>
                                          @endforeach
                                          @endif
                                          @endforeach
                                          
                                      </div>
                                      <div class="row">
                                          <div class="col-md-12 py-2">
                                              <h3 class="display-8" style="font-weight: 700;">Videos
                                              </h3>
                                          </div>
                                          @foreach ($timeLine as $item)
                                          @if ((array) $item->videos)
                                          @foreach ((array) $item->videos as $video)
                                          <div class="col-md-2 mb-2">
                                              <video src="{{ $video['file'] }}" width="100%" controls="true"
                                                  autoplay="false">
                                                  <source src="{{ $video['file'] }}">
                                              </video>
                                          </div>
                                          @endforeach
                                          @endif
                                          @endforeach

                                      </div>
                                      <br>
                                      <hr>
                                      <div class="row">
                                          <div class="col-md-12 py-2">
                                              <h3 class="display-4" style="font-size: 25px;font-weight: 700;">Payment
                                                  Request
                                              </h3>
                                          </div>
                                      </div>
                                      <div class="row container">
                                          <div class="col-md-12">
                                              <h3 class="display-8 mb-2" style="font-weight: 700;">Photos
                                              </h3>
                                          </div>
                                          @foreach ($project->paymentRequest as $paymentrequestItem)
                                          @foreach ((array) $paymentrequestItem->images as $image)
                                          @php
                                          $photo = $image;
                                          if ($photo) {
                                          if (filter_var($photo, FILTER_VALIDATE_URL)) {
                                          $photo = explode('/', $photo);
                                          $photo = $photo[count($photo) - 2] . '/' . $photo[count($photo) - 1];
                                          }
                                          }
                                          @endphp

                                          <div class="col-md-2 mb-2">
                                              <a target="_blank" href="/stream/{{ $photo }}">
                                                  <img src="/stream/{{ $photo }}" class="img-fluid" alt="Project Photo">
                                              </a>
                                          </div>
                                          @endforeach
                                          @endforeach
                                      </div>
                                      <div class="row">
                                          <div class="col-md-12 py-2">
                                              <h3 class="display-8" style="font-weight: 700;">Videos
                                              </h3>
                                          </div>
                                          @if ((array) $project->paymentRequest)
                                          @foreach ($project->paymentRequest as $paymentrequestItem)
                                          @foreach ((array) $paymentrequestItem->videos as $video)
                                          <div class="col-md-2 mb-2">
                                              <video src="{{ $video['file'] }}" width="100%" controls="true"
                                                  autoplay="false">
                                                  <source src="{{ $video['file'] }}">
                                              </video>
                                          </div>
                                          @endforeach
                                          @endforeach
                                          @endif
                                      </div>

                                  </section>
                                  <!-- Section: Images -->


                              </section>
                              <!-- Modal gallery -->
                          </div>
                          {{-- <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                              <p>
                                  Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice
                                  cream. Gummies
                                  halvah
                                  tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream cheesecake
                                  fruitcake.
                              </p>
                              <p class="mb-0">
                                  Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu
                                  halvah
                                  cotton candy
                                  liquorice caramels.
                              </p>
                          </div> --}}

                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
