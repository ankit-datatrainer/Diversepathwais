@if($isHome)
<footer class="site-footer" style="position:relative;overflow:hidden">
<!-- Floating Ambient Light Orbs -->
<div class="blob blob--gold float-drift" style="width:450px;height:450px;left:-80px;top:-60px;position:absolute;opacity:0.1;pointer-events:none"></div>
<div class="blob blob--blue float-slow-1" style="width:420px;height:420px;right:-60px;bottom:-40px;position:absolute;opacity:0.16;border-radius:50%;background:radial-gradient(circle,rgba(47,95,168,.28),transparent 70%);pointer-events:none"></div>
<div class="float-shape float-shape--ring float-spin" style="bottom:30px;right:4%;width:90px;height:90px;border-color:rgba(255,255,255,.08)"></div>

<div class="shell" style="position:relative;z-index:2">
@else
<footer class="site-footer">
<div class="shell">
@endif
<div class="footer-grid" data-anim-group="80">
<div class="footer-brand" data-anim="up">
<img src="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}" alt="Diverse Pathwais PVT LTD." width="180" height="94"/>
<p>Diverse Pathwais PVT LTD. is recognized as a leading global resettlement and immigration consultancy, providing expert guidance across all categories of immigration. Since its establishment in 2025, the organization has built extensive experience in immigration and citizenship law, specializing in Skilled, Study Abroad, and Business Immigration services.</p>
<div class="social"><a href="https://www.facebook.com/profile.php?id=61591898733892" target="_blank" rel="noopener" aria-label="Facebook"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 22v-8h2.7l.4-3.1h-3.1V8.9c0-.9.25-1.5 1.55-1.5H16.7V4.62A21 21 0 0 0 14.28 4.5c-2.4 0-4.05 1.47-4.05 4.16v2.24H7.5V14h2.73v8z"/></svg></a><a href="https://www.instagram.com/diversepathwaispvtltd/?hl=en" target="_blank" rel="noopener" aria-label="Instagram"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1.2" fill="currentColor" stroke="none"/></svg></a><a href="#" aria-label="LinkedIn" rel="noopener"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a><a href="#" aria-label="Youtube" rel="noopener"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.6 7.2a2.5 2.5 0 0 0-1.77-1.77C18.25 5 12 5 12 5s-6.25 0-7.83.43A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.77 1.77C5.75 19 12 19 12 19s6.25 0 7.83-.43a2.5 2.5 0 0 0 1.77-1.77A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8zM10 15.02V8.98L15.2 12z"/></svg></a></div>
</div>
<div data-anim="up">
<h3>Visa Categories</h3>
<ul><li><a href="{{ url('skilled-worker-visa') }}">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}">Work Permit</a></li></ul>
</div>
<div data-anim="up">
<h3>Quick Link</h3>
<ul>
<li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('about-us') }}">About Us</a></li>
<li><a href="{{ route('blog.index') }}">Blog</a></li>
<li><a href="{{ url('contact-us') }}">Contact Us</a></li>
</ul>
</div>
<div data-anim="up">
<h3>Stay in Touch</h3>
<ul class="footer-contact">
<li><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg><div><a href="tel:+919773916555">+91 9773916555</a><br/><a href="tel:+919319090505">+91 9319090505</a></div></li>
<li><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg><a href="mailto:diversepathwise@gmail.com">diversepathwise@gmail.com</a></li>
<li><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg><div><strong class="footer-contact__label">Registered Office:</strong><span class="footer-contact__address">Ground floor No. 112, World Trade Centre, Near The Lalit Hotel, Connaught Place, New Delhi, Delhi-110001</span></div></li>
<li><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg><div><strong class="footer-contact__label">Other branches:</strong><span class="footer-contact__address">Fourth Floor No. 407, World Trade Centre, Near The Lalit Hotel, Connaught Place, New Delhi, Delhi-110001</span></div></li>
</ul>
</div>
</div>
<div class="footer-note"><p>Diverse Pathwais PVT LTD. is committed to providing reliable and professional immigration and resettlement consultancy services. Only authorized representatives, including licensed lawyers and certified immigration consultants (such as MARA Agents, RCICs, and other recognized professionals), are permitted to provide immigration advice and handle client matters on behalf of Diverse Pathwais PVT LTD..</p><p>Our management team, directors, and officers are not personally engaged in providing immigration representation. Any communication, advice, or representation outside of our authorized legal representatives should not be considered as official advice from Diverse Pathwais PVT LTD..</p><p>All immigration-related matters are strictly managed by qualified professionals in accordance with the laws and regulations of the respective countries.</p></div>
<div class="footer-bottom">
<p>&copy; Diverse Pathwais PVT LTD. <span data-year>2025</span>. All rights reserved.</p>
<ul><li><a href="{{ url('disclaimers') }}">Disclaimers</a></li><li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li><li><a href="{{ url('feedback') }}">Feedback</a></li><li><a href="{{ url('careers-at-diverse-pathwais') }}">Careers at Diverse Pathwais</a></li><li><a href="{{ url('refer-a-friend') }}">Refer a Friend</a></li><li><a href="{{ url('contact-us') }}">Contact Us</a></li><li><a href="{{ url('terms-and-conditions') }}">Terms and Conditions</a></li><li><a href="{{ url('/') }}#testimonials">Diverse Pathwais Reviews</a></li><li><a href="{{ url('corporate-emails') }}">Corporate Emails</a></li></ul>
</div>
</div>
</footer>
<div class="wa-float">
<span class="wa-float__label">Hii, Looking for Immigration or Settled&nbsp;down&nbsp;or&nbsp;work&nbsp;permit</span>
<a class="wa-float__btn" href="https://wa.me/919319090505" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
<svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15s-.77.96-.94 1.16c-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.05-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.28.17-1.41-.07-.13-.27-.2-.57-.35zM12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.11.82.83-3.04-.2-.31a8.2 8.2 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24a8.2 8.2 0 0 1 5.82 2.42 8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23z"/></svg>
</a>
</div>
<button class="to-top" data-to-top type="button" aria-label="Back to top"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5m0 0-7 7m7-7 7 7"/></svg></button>
