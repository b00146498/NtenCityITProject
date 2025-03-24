@extends('layouts.mobile')

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header">
    <!-- Logo on the Left -->
    <img src="{{ asset('ntencitylogo.png') }}" alt="Ntencity Logo" class="logo">

    <!-- User Name on the Right -->
    @auth
        <div class="user-info">
            {{ Auth::user()->name }} <i class="fas fa-user"></i>
        </div>
    @endauth
</div>

<div class="container px-3 py-4">
    <h2 class="text-center mb-4 fw-bold">Help Center</h2>

    <div class="accordion" id="faqAccordion">
        <!-- Appointments -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Booking Appointments
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body small">
                    <strong>How do I book an appointment?</strong>
                    <p>Go to your Client Dashboard. You’ll see a list of employees from your registered practice. Tap on an employee and then select “Book Appointment”. Choose a time and confirm.</p>

                    <strong>How do I cancel or reschedule?</strong>
                    <p>In your Appointments section, find the appointment you want to change. Tap it and you’ll see options to reschedule or cancel.</p>

                    <strong>Where can I see my upcoming sessions?</strong>
                    <p>Your upcoming sessions are visible in your Appointments page and may also appear on your dashboard if enabled by your trainer.</p>
                </div>
            </div>
        </div>

        <!-- Personalised Training -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Your Exercise Plan
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body small">
                    <strong>Where is my plan?</strong>
                    <p>Your trainer creates a custom plan for you. You can find it in the “To Do” section of your account. It’s like your exercise homework.</p>

                    <strong>How do I complete a task?</strong>
                    <p>Once you complete an exercise, just tap the checkbox next to it in your plan. This helps your trainer track your progress.</p>

                    <strong>Are there any tutorials?</strong>
                    <p>Yes! Many exercises come with built-in videos. Just tap the exercise and you’ll see a “Play” icon to view a demonstration.</p>
                </div>
            </div>
        </div>

        <!-- Account & Help -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Your Profile & Help
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body small">
                    <strong>Where can I update my details?</strong>
                    <p>Tap your profile icon (bottom-right of your screen) and go to “Personal Details” to update your info.</p>

                    <strong>How do I change my password or log out?</strong>
                    <p>In the same Profile area, you’ll find options to change your password or log out of your account securely.</p>

                    <strong>Need help?</strong>
                    <p>If something doesn’t work, head to the Help tab or reach out using the support options at the bottom of this page.</p>
                </div>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Account & Profile Settings
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body small">
                    <strong>Update profile info:</strong>
                    <p>Tap your profile at the top right, go to "Personal Details" to update info.</p>

                    <strong>Change profile picture:</strong>
                    <p>In "Personal Details", tap "Change Picture" to upload a new one.</p>

                    <strong>Logout:</strong>
                    <p>Tap your profile icon and choose "Logout" from the dropdown.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Support Section -->
    <div class="mt-4">
        <h4 class="fw-bold">Need Help?</h4>

        <div class="card my-3 p-3">
            <div class="text-center">
                <i class="fas fa-envelope fa-2x mb-2" style="color: #dbb959;"></i>
                <h5>Email Support</h5>
                <p class="mb-1">support@ntencity.com</p>
                <a href="mailto:support@ntencity.com" class="btn btn-sm btn-outline-secondary">Email Us</a>
            </div>
        </div>

        <div class="card my-3 p-3">
            <div class="text-center">
                <i class="fas fa-phone-alt fa-2x mb-2" style="color: #dbb959;"></i>
                <h5>Phone Support</h5>
                <p>+353 1 234 5678</p>
            </div>
        </div>

        <div class="text-muted text-center mt-3">
            <p class="small">Support Hours:<br>
                Mon-Fri: 9:00 AM - 6:00 PM<br>
                Sat: 10:00 AM - 2:00 PM<br>
                Sun: Closed</p>
        </div>
    </div>
</div>
<!-- Bottom Navigation -->
<nav class="bottom-nav">
    <a href="{{ url('/client/clientdashboard') }}" class="nav-item"><i class="fas fa-home"></i></a>
    <a href="{{ url('/progress') }}" class="nav-item"><i class="fas fa-list"></i></a>
    <a href="{{ url('/appointments') }}" class="nav-item"><i class="fas fa-clock"></i></a>
    <a href="{{ url('/workoutlogs') }}" class="nav-item"><i class="far fa-check-circle"></i></a>
    <a href="#" class="nav-item"><i class="fas fa-comment"></i></a>
    <a href="{{ url('/clientprofile') }}" class="nav-item active"><i class="fas fa-user"></i></a>
</nav>
<style>
/* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .logo {
        width: 135px;
        height: auto;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-info i {
        font-size: 18px;
        margin-left: 10px;
    }
/* Bottom Navigation */
    .bottom-nav {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 350px;
    background: white;
    display: flex;
    justify-content: space-around;
    padding: 12px 0;
    box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
    border-top: 1px solid #ccc;
    z-index: 1000;
    border-radius: 0 0 15px 15px;
    }


</style>
@endsection
