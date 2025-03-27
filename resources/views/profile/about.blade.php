@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="text-center mb-4">About ntencity</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Our Mission</h4>
                    <p>At ntencity, we're dedicated to transforming how health and fitness professionals connect with and manage their clients. Our platform streamlines administrative tasks, enhances communication, and empowers both practitioners and clients to achieve better health outcomes together.</p>
                    
                    <h4 class="mt-4">Who We Are</h4>
                    <p>Founded in 2025, ntencity was born from the vision to create a comprehensive management system specifically designed for physiotherapists, personal trainers, and fitness centers. Our team combines expertise in healthcare management, software development, and user experience design to deliver a solution that truly serves the needs of health and fitness professionals.</p>
                    
                    <h4 class="mt-4">What We Offer</h4>
                    <ul>
                        <li><strong>Seamless Appointment Management</strong> - Schedule, reschedule, and track client appointments with ease</li>
                        <li><strong>Client Progress Tracking</strong> - Document and monitor client progress through detailed notes and metrics</li>
                        <li><strong>Personalized Training Plans</strong> - Create and assign customized training programs for each client</li>
                        <li><strong>Integrated Exercise Library</strong> - Access a comprehensive database of exercises with video demonstrations</li>
                        <li><strong>Secure Communication</strong> - Maintain client confidentiality with our secure messaging system</li>
                        <li><strong>Data-Driven Insights</strong> - Make informed decisions with analytics and reporting tools</li>
                    </ul>
                    
                    <h4 class="mt-4">Our Values</h4>
                    <div class="row mt-3">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-heart fa-2x mb-3" style="color: #dbb959;"></i>
                                    <h5>Client-Centered</h5>
                                    <p>We design our solutions with the client journey at the forefront, ensuring positive experiences and outcomes.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-shield-alt fa-2x mb-3" style="color: #dbb959;"></i>
                                    <h5>Integrity</h5>
                                    <p>We uphold the highest standards of data security and professional ethics in everything we do.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-line fa-2x mb-3" style="color: #dbb959;"></i>
                                    <h5>Continuous Improvement</h5>
                                    <p>We constantly evolve our platform based on user feedback and industry best practices.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h4 class="mt-4">Our Vision</h4>
                    <p>We envision a future where health and fitness professionals can focus entirely on what they do best—helping their clients reach their health and fitness goals—while ntencity handles the administrative burden. By providing intuitive tools for practice management, we aim to elevate the standard of care across the fitness and wellness industry.</p>
                    
                    <div class="text-center mt-4">
                        <p class="fst-italic">Join us in our mission to transform health and fitness management, one practice at a time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
h2, h4, h5 {
    color: #333333;
    font-weight: 700;
}

h2 {
    font-size: 2.2rem;
    border-bottom: 2px solid #dbb959;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

h4 {
    font-size: 1.5rem;
    margin-top: 2rem;
    color: #444;
}

h5 {
    font-size: 1.2rem;
    color: #555;
}
</style>