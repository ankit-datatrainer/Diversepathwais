<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Three starter articles — the same three stories the static homepage showed
 * in its "Group Media" section, now as full, SEO-ready blog posts.
 */
class BlogSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->posts() as $data) {
            if (! Post::where('slug', $data['slug'])->exists()) {
                Post::create($data);
            }
        }
    }

    protected function posts(): array
    {
        return [
            [
                'title' => 'Canada Immigration Pathways: Opportunities for Skilled Professionals',
                'slug' => 'canada-immigration-pathways-skilled-professionals',
                'excerpt' => 'Express Entry, Provincial Nominee Programs and employer-driven streams explained — how skilled professionals can choose the right route to Canadian permanent residence.',
                'featured_image' => 'assets/img/Canada-Immigration-Pathways-1-1024x576.webp',
                'featured_image_alt' => 'Canada immigration pathways for skilled professionals',
                'category' => 'Skilled Immigration',
                'tags' => 'Canada, Express Entry, PNP, skilled worker visa, permanent residence',
                'author_name' => 'Diverse Pathwais Editorial Team',
                'status' => 'published',
                'published_at' => Carbon::parse('2026-10-13 10:00:00'),
                'meta_title' => 'Canada Immigration Pathways for Skilled Professionals (2026)',
                'meta_description' => 'Explore Canada immigration pathways for skilled professionals — Express Entry, PNP and employer streams — and learn how to build a winning profile.',
                'meta_keywords' => 'Canada immigration pathways, Express Entry, Provincial Nominee Program, skilled worker Canada, Canada PR',
                'focus_keyword' => 'Canada immigration pathways',
                'robots' => 'index, follow',
                'in_sitemap' => true,
                'content' => <<<'HTML'
<p>Canada remains one of the most welcoming destinations in the world for skilled professionals. Its economy depends on talent from abroad, and the government runs several well-defined Canada immigration pathways designed to bring qualified workers — and their families — into the country as permanent residents.</p>
<p>Choosing the right route is the single most important decision in your application. The wrong program can mean months of waiting or an avoidable refusal; the right one can move you from profile to landing in a predictable timeline. Here is how the main options compare.</p>
<h2>1. Express Entry: the federal fast track</h2>
<p>Express Entry is the online system that manages three federal economic programs: the Federal Skilled Worker Program, the Federal Skilled Trades Program and the Canadian Experience Class. Candidates create a profile and are ranked using the Comprehensive Ranking System (CRS), which awards points for:</p>
<ul>
<li>Age, education and official-language test scores (IELTS, CELPIP, TEF or TCF)</li>
<li>Skilled work experience, inside or outside Canada</li>
<li>A spouse or partner's education, language ability and experience</li>
<li>Additional factors such as a provincial nomination, French-language ability or Canadian study</li>
</ul>
<p>Regular draws invite the highest-ranked candidates to apply for permanent residence. Because scores are relative, every point matters — a stronger language result or an educational credential assessment can lift a profile above the cut-off.</p>
<h2>2. Provincial Nominee Programs (PNP)</h2>
<p>Most provinces and territories run their own nominee programs aimed at the specific occupations their local labour markets need. A provincial nomination adds a significant boost to an Express Entry score, and many streams also accept candidates outside Express Entry.</p>
<p>PNPs reward candidates who match local demand — healthcare, technology, skilled trades, agriculture and transport are frequent priorities — and some streams favour people with a job offer, previous study or family ties in the province.</p>
<h2>3. Employer-driven and regional routes</h2>
<p>A genuine job offer from a Canadian employer opens additional doors. Employer-supported work permits can lead to Canadian experience, which in turn strengthens a later permanent residence application. Regional and community-based programs invite newcomers to smaller cities that are actively looking for skilled workers.</p>
<blockquote><p>The best pathway is rarely the most popular one — it is the one that matches your occupation, your scores and the province that needs your skills.</p></blockquote>
<h2>How to build a winning profile</h2>
<ol>
<li><strong>Get an honest assessment.</strong> Map your age, education, language ability and experience against each program before spending on tests.</li>
<li><strong>Invest in language scores.</strong> Language results are one of the fastest ways to raise a CRS score.</li>
<li><strong>Validate your credentials early.</strong> An Educational Credential Assessment and properly documented work references prevent delays later.</li>
<li><strong>Watch provincial opportunities.</strong> Streams open and close throughout the year; timing matters.</li>
<li><strong>Prepare proof of funds.</strong> Most economic programs require settlement funds unless you hold a valid job offer.</li>
</ol>
<h2>How Diverse Pathwais can help</h2>
<p>Our consultants review your profile, recommend the most suitable Canada immigration pathways and manage every step from documentation to submission. Book a <a href="/eligibility-assessment">free eligibility assessment</a> or <a href="/contact-us">contact our team</a> to start planning your move with confidence.</p>
HTML,
            ],
            [
                'title' => 'Study Abroad in Canada: Building a Global Future',
                'slug' => 'study-abroad-in-canada-global-future',
                'excerpt' => 'From choosing a designated learning institution to securing your study permit — a practical roadmap for students who want to study abroad in Canada.',
                'featured_image' => 'assets/img/Study-Abroad-in-Canada-1-1024x576.webp',
                'featured_image_alt' => 'International students planning to study abroad in Canada',
                'category' => 'Study Abroad',
                'tags' => 'study abroad, Canada, student visa, study permit, universities',
                'author_name' => 'Diverse Pathwais Editorial Team',
                'status' => 'published',
                'published_at' => Carbon::parse('2026-10-08 10:00:00'),
                'meta_title' => 'Study Abroad in Canada: Student Visa & Admission Guide',
                'meta_description' => 'Plan to study abroad in Canada? Learn how to choose a college, meet admission rules, apply for a study permit and work while you study.',
                'meta_keywords' => 'study abroad in Canada, Canada student visa, study permit, Canadian universities, international students',
                'focus_keyword' => 'study abroad in Canada',
                'robots' => 'index, follow',
                'in_sitemap' => true,
                'content' => <<<'HTML'
<p>Every year, hundreds of thousands of international students choose to study abroad in Canada. World-class universities and colleges, a safe and multicultural society, and the opportunity to gain Canadian work experience after graduation make it one of the strongest choices for ambitious students.</p>
<p>A successful study plan starts long before the visa application. Here is a step-by-step roadmap to help you prepare.</p>
<h2>Step 1: Choose the right program and institution</h2>
<p>Only a Designated Learning Institution (DLI) can accept international students for a study permit. Look beyond rankings and compare:</p>
<ul>
<li>How the program connects to your previous education and career goals</li>
<li>Tuition fees, living costs in the city and available scholarships</li>
<li>Co-op or internship components that build Canadian experience</li>
<li>Whether the program and institution support post-graduation work options</li>
</ul>
<h2>Step 2: Meet admission requirements</h2>
<p>Most institutions ask for academic transcripts, an English or French language test score, a statement of purpose and, for some programs, a portfolio or recommendation letters. Apply early — popular programs fill quickly and an acceptance letter is required before you can apply for a study permit.</p>
<h2>Step 3: Apply for your study permit</h2>
<p>Your study permit application must show the visa officer that you are a genuine student. A strong file typically includes:</p>
<ol>
<li><strong>A letter of acceptance</strong> from your DLI, plus any provincial attestation required at the time you apply.</li>
<li><strong>Proof of financial support</strong> covering tuition, living expenses and return travel.</li>
<li><strong>A clear study plan</strong> explaining why this program, why Canada and how it fits your future.</li>
<li><strong>Identity and civil documents,</strong> medical examination and biometrics where required.</li>
</ol>
<blockquote><p>A consistent story matters more than a long one: your academic history, chosen program and career plan should clearly connect.</p></blockquote>
<h2>Step 4: Work while you study — and after</h2>
<p>Eligible international students may work part-time during academic sessions and full-time during scheduled breaks, subject to current rules. After graduation, eligible students may apply for a post-graduation work permit, gaining Canadian experience that can support a future permanent residence application.</p>
<h2>Common mistakes to avoid</h2>
<ul>
<li>Choosing a program unrelated to your background without a convincing reason</li>
<li>Showing funds that cannot be traced or explained</li>
<li>Applying too late for the intake and rushing the documentation</li>
</ul>
<h2>Start your journey with Diverse Pathwais</h2>
<p>Our <a href="/student-visa">student visa team</a> helps with career counselling, university selection, admissions and the complete study permit file. <a href="/contact-us">Talk to a consultant</a> today and take the first step towards a global future.</p>
HTML,
            ],
            [
                'title' => 'Continuous Learning: From Beginners to Global Professionals',
                'slug' => 'continuous-learning-beginners-to-global-professionals',
                'excerpt' => 'Why continuous learning is the real visa for a global career — and the practical habits that turn beginners into internationally competitive professionals.',
                'featured_image' => 'assets/img/Continuous-Learning-1-1024x576.webp',
                'featured_image_alt' => 'Professionals engaged in continuous learning for a global career',
                'category' => 'Career Growth',
                'tags' => 'continuous learning, career growth, skills, global careers, upskilling',
                'author_name' => 'Diverse Pathwais Editorial Team',
                'status' => 'published',
                'published_at' => Carbon::parse('2026-10-01 10:00:00'),
                'meta_title' => 'Continuous Learning: Build a Global Career from Day One',
                'meta_description' => 'Discover how continuous learning helps beginners become global professionals — language, certifications and skills that strengthen visa profiles.',
                'meta_keywords' => 'continuous learning, global career, upskilling, professional certifications, language skills for immigration',
                'focus_keyword' => 'continuous learning',
                'robots' => 'index, follow',
                'in_sitemap' => true,
                'content' => <<<'HTML'
<p>Talent moves across borders more easily than ever, but the professionals who succeed abroad share one habit: continuous learning. Whether you are a fresh graduate or an experienced specialist, the skills you keep building determine which opportunities — and which visas — are open to you.</p>
<h2>Why learning matters for your immigration profile</h2>
<p>Most skilled immigration systems are designed to reward human capital. Points-based programs score education, language ability and skilled experience, and employers abroad look for candidates who can adapt quickly to new workplaces. Each new qualification can translate directly into a stronger application.</p>
<ul>
<li><strong>Language ability</strong> is often the highest-value factor you can still improve.</li>
<li><strong>Recognised certifications</strong> help employers and assessing bodies understand your skills.</li>
<li><strong>Documented experience</strong> in in-demand occupations opens employer-driven routes.</li>
</ul>
<h2>From beginner to global professional: a practical plan</h2>
<h3>1. Build strong foundations</h3>
<p>Start with communication. Daily reading, listening and speaking practice in English or French pays off in test results, interviews and everyday life abroad.</p>
<h3>2. Add industry credentials</h3>
<p>Short, recognised certifications — in project management, cloud technology, healthcare, accounting or the skilled trades — show employers that your knowledge meets international standards.</p>
<h3>3. Learn by doing</h3>
<p>Internships, freelance projects and volunteer roles create the documented experience that visa officers and employers need to see. Keep reference letters and records from the start.</p>
<h3>4. Understand the destination</h3>
<p>Workplace culture, licensing rules and job-search norms differ from country to country. Learning them early shortens the time it takes to settle and find the right role.</p>
<blockquote><p>Every certificate, test score and project you complete today becomes evidence in tomorrow's application.</p></blockquote>
<h2>Keep growing after you move</h2>
<p>Learning does not stop at landing. Newcomers who continue upskilling — through bridging programs, local certifications and professional networks — progress faster and build long-term careers in their new country.</p>
<h2>Let us map your next step</h2>
<p>Not sure which skills will make the biggest difference to your profile? Our consultants can identify the gaps and the opportunities. Try our <a href="/eligibility-assessment">eligibility assessment</a> or explore the <a href="/skilled-worker-visa">skilled worker visa</a> options available to you.</p>
HTML,
            ],
        ];
    }
}
