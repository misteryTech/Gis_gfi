<?php
    include("header.php");

?>

<body>


<?php
    include("topnav.php");
?>
<header class="pt-5">
    <div class="container pt-4 pt-xl-5">
        <div class="row pt-5">
            <div class="col-md-8 text-center text-md-start mx-auto">
                <div class="text-center">
                    <h1 class="display-4 fw-bold mb-5">Welcome to the Online Grading Portal</h1>
                    <p class="fs-5 text-muted mb-5">
                        Simplify your grading process with our integrated tools for seamless collaboration between students and educators.
                    </p>
                    <form class="d-flex justify-content-center flex-wrap" method="post" data-bs-theme="light">
                        <div class="shadow-lg mb-3">
                            <input class="form-control" type="email" name="email" placeholder="Enter your email to stay updated">
                        </div>
                        <div class="shadow-lg mb-3">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-10 mx-auto">
                <div class="text-center position-relative">
                    <img class="img-fluid" src="assets/img/illustrations/meeting.svg" alt="Illustration of Team Collaboration" style="width: 800px;">
                </div>
            </div>
        </div>
    </div>
</header>



<section>
    <div class="container py-4 py-xl-5">
        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
            <!-- Card 1: Grading Features -->
            <div class="col">
                <div class="card border-light border-1 d-flex justify-content-center p-4">
                    <div class="card-body">
                        <div class="bs-icon-lg bs-icon-rounded bs-icon-secondary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-4 bs-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-school">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="fw-bold">Automated Grading</h4>
                            <p class="text-muted">Simplify your grading process with automated calculations and instant feedback for students.</p>
                            <button class="btn btn-sm px-0" type="button">Learn More&nbsp;
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-arrow-right">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card 2: Student Performance Tracking -->
            <div class="col">
                <div class="card border-light border-1 d-flex justify-content-center p-4">
                    <div class="card-body">
                        <div class="bs-icon-lg bs-icon-rounded bs-icon-secondary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-4 bs-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-school">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="fw-bold">Student Performance Tracking</h4>
                            <p class="text-muted">Monitor student progress with real-time data and insightful analytics on their performance.</p>
                            <button class="btn btn-sm px-0" type="button">Learn More&nbsp;
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-arrow-right">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card 3: Teacher Collaboration Tools -->
            <div class="col">
                <div class="card border-light border-1 d-flex justify-content-center p-4">
                    <div class="card-body">
                        <div class="bs-icon-lg bs-icon-rounded bs-icon-secondary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-4 bs-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-school">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="fw-bold">Teacher Collaboration Tools</h4>
                            <p class="text-muted">Enhance teamwork with tools designed for teachers to coordinate, discuss, and plan grading strategies.</p>
                            <button class="btn btn-sm px-0" type="button">Learn More&nbsp;
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-arrow-right">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <section class="py-4 py-xl-5">
        <div class="container">
            <div class="bg-primary border rounded border-0 border-primary overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-6 d-flex flex-column justify-content-center">
                        <div class="text-white p-4 p-md-5">
                            <h2 class="fw-bold mb-3">Ut semper sed, aptent taciti conubia.</h2>
                            <p class="mb-4">Tincidunt laoreet leo, adipiscing taciti tempor. Primis senectus sapien, risus donec ad fusce augue interdum.</p>
                            <div class="my-3"><a class="btn btn-secondary me-2 mt-2" role="button" href="#">Button</a><a class="btn btn-light mt-2" role="button" href="#">Button</a></div>
                        </div>
                    </div>
                    <div class="col-md-6 order-first order-md-last" style="min-height: 250px;"><img class="w-100 h-100 fit-contain pt-5 pt-md-0" src="assets/img/illustrations/web-development.svg"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container py-4 py-xl-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="display-6 fw-bold mb-4">Check out<br>our <span class="underline">amazing plans</span></h2>
                    <p class="text-muted">Curae hendrerit donec commodo hendrerit egestas tempus, turpis facilisis nostra nunc. Vestibulum dui eget ultrices.</p>
                </div>
            </div>
            <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
                <div class="col">
                    <div class="card border-0 h-100">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <h6 class="fw-bold text-muted">Standard</h6>
                                <h4 class="display-5 fw-bold mb-4">$15</h4>
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Lectus ut nibh quam, felis porttitor.</span></li>
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Ante nec venenatis etiam lacinia.</span></li>
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Porta suscipit netus ad ac.</span></li>
                                </ul>
                            </div><a class="btn btn-primary" role="button" href="#">Button</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-secondary border-2 h-100">
                        <div class="card-body d-flex flex-column justify-content-between p-4"><span class="badge bg-secondary position-absolute top-0 end-0 rounded-bottom-left text-uppercase text-primary">Most Popular</span>
                            <div>
                                <h6 class="fw-bold text-muted">Pro</h6>
                                <h4 class="display-5 fw-bold mb-4">$38</h4>
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Lectus ut nibh quam, felis porttitor.</span></li>
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Ante nec venenatis etiam lacinia.</span></li>
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Porta suscipit netus ad ac.</span></li>
                                </ul>
                            </div><a class="btn btn-warning" role="button" href="#">Button</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 h-100">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div class="pb-4">
                                <h6 class="fw-bold text-muted">Enterprise</h6>
                                <h4 class="display-5 fw-bold mb-4">$70</h4>
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Lectus ut nibh quam, felis porttitor.</span></li>
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Ante nec venenatis etiam lacinia.</span></li>
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Porta suscipit netus ad ac.</span></li>
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary-emphasis">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg></span><span>Morbi praesent aptent integer.</span></li>
                                </ul>
                            </div><a class="btn btn-primary" role="button" href="#">Button</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   <section class="py-4 py-xl-5 mb-5">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="display-6 fw-bold mb-5"><span class="pb-3 underline">FAQ<br></span></h2>
                    <p class="text-muted mb-5">Curae hendrerit donec commodo hendrerit egestas tempus, turpis facilisis nostra nunc. Vestibulum dui eget ultrices.</p>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-8 mx-auto">
                    <div class="accordion text-muted" role="tablist" id="accordion-1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" role="tab"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-1" aria-expanded="true" aria-controls="accordion-1 .item-1">Aenean arcu euismod aliquam, volutpat consequat?</button></h2>
                            <div class="accordion-collapse collapse show item-1" role="tabpanel" data-bs-parent="#accordion-1">
                                <div class="accordion-body">
                                    <p>Maecenas diam volutpat, erat quis enim cras lobortis vivamus donec tempor. Congue ultrices donec turpis vivamus. Laoreet aenean metus, mi nunc massa feugiat duis. Pharetra erat consequat purus curae quisque, etiam accumsan class.</p>
                                    <p class="mb-0">Commodo rutrum quisque curabitur habitasse, suspendisse etiam.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" role="tab"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-2" aria-expanded="false" aria-controls="accordion-1 .item-2">Lorem quam erat placerat mollis, rhoncus senectus?</button></h2>
                            <div class="accordion-collapse collapse item-2" role="tabpanel" data-bs-parent="#accordion-1">
                                <div class="accordion-body">
                                    <p class="mb-0">Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" role="tab"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-3" aria-expanded="false" aria-controls="accordion-1 .item-3">Iaculis accumsan id, facilisis proin ipsum velit neque?</button></h2>
                            <div class="accordion-collapse collapse item-3" role="tabpanel" data-bs-parent="#accordion-1">
                                <div class="accordion-body">
                                    <p class="mb-0">Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
    <section class="py-4 py-xl-5">
        <div class="container">
            <div class="text-white bg-primary border rounded border-0 border-primary d-flex flex-column justify-content-between flex-lg-row p-4 p-md-5">
                <div class="pb-2 pb-lg-1">
                    <h2 class="fw-bold text-secondary mb-2">Not sure which plan suits you?</h2>
                    <p class="mb-0">Imperdiet consectetur dolor, tristique himenaeos ultrices tristique neque.</p>
                </div>
                <div class="my-2"><a class="btn btn-light fs-5 py-2 px-4" role="button" href="contacts.html">Contact us</a></div>
            </div>
        </div>
    </section>

<?php
            include("footer.php");
?>