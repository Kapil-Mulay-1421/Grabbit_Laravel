@extends('layouts.app', ['search' => $search ?? null])

@section('content')

    <div class="about-container">
        <H1 style="text-align: center; font-size: 50px; margin-top: 50px;">Grabbit India</H1>
        <h2 style="text-align: center">Local is the new Global.</h2><br>
        
        <p>
        <b style="font-size: 18px;">
            Welcome to GrabbitIndia: Empowering a Nation, One Innovation at a Time
        </b><br>
            GrabbitIndia is not just a company; it's a vision—an ambitious endeavor to transform the landscape of commerce, technology, and media in India. As a premier national conglomerate, we pride ourselves on delivering a comprehensive suite of services that cater to the dynamic needs of our diverse clientele. Our mission is to innovate, inspire, and instill trust in everything we do, setting new standards for excellence across multiple industries.

        </p>
        <div>
        <b style="font-size: 18px;">Our Multifaceted Offerings</b><br>

        <p>
            <b>E-commerce Excellence:</b>
            At GrabbitIndia, we redefine the shopping experience with our state-of-the-art e-commerce platform. Offering a vast array of products—from everyday necessities to exclusive luxury items—we ensure that convenience meets quality. Our robust supply chain and seamless user interface guarantee that what you need is just a click away, delivered swiftly to your doorstep.
        </p>
        <p>
            <b>Cutting-Edge Multi-chain Asset Relocation:</b>
            Navigating the complexities of logistics, GrabbitIndia excels in multi-chain asset relocation. We offer tailored solutions for businesses and individuals, ensuring the safe, efficient, and timely movement of assets across towns, cities, and states. Our advanced tracking systems and dedicated support teams provide peace of mind, knowing your valuable goods are in the safest hands.
        </p>
        <p>
            <b>Pioneering Technology & Fintech Innovations:</b>
            In an era where digital transformation is key, GrabbitIndia leads the way with groundbreaking technology and fintech solutions. We simplify financial processes with secure, intuitive platforms designed to meet the demands of the modern consumer. From personal finance management to corporate financial solutions, our tech-savvy approaches empower users to achieve their financial goals effortlessly.
        </p>
        <p>
            <b>Dynamic Media Creation & Digital Content:</b>
            In the world of storytelling, GrabbitIndia stands out with compelling media and digital content creation. Our talented teams craft visually stunning and emotionally engaging content that resonates with audiences across all platforms. Whether it’s brand storytelling, digital marketing, or multimedia production, we breathe life into ideas and help brands connect with their target audiences in meaningful ways.
        </p>
        <p>
        </div>
        <div><br>
            <b style="font-size: 18px;">Why Choose GrabbitIndia?</b>
        </p>
        <p>
            <b>&#9642; Innovation at Our Core:</b> We are driven by a relentless pursuit of innovation, constantly seeking new ways to improve and expand our services.
        </p>
        <p>
            <b>&#9642; Customer-Centric Approach:</b> Our customers are at the heart of everything we do. We listen, adapt, and deliver solutions that exceed expectations.
        </p>
        <p>
            <b>&#9642; Nationwide Reach, Local Touch:</b> With a presence that spans the nation, we combine the efficiency of a large conglomerate with the personalized service of a local partner.
        </p>
        <p>
            <b>&#9642; Sustainability and Integrity:</b> We are committed to responsible business practices that prioritize sustainability, ethical standards, and integrity in all our operations.
        </p>
        </div>
        <p>
            <b>Join the Revolution. Experience the Future with GrabbitIndia.</b><br>
            From the bustling streets of Mumbai to the serene landscapes of Kerala, from the tech hubs of Bangalore to the historic cities of the North, GrabbitIndia is everywhere you need us to be. Together, let’s build a brighter, smarter, and more connected India. Discover the possibilities. Embrace the future. Grab it with GrabbitIndia.
        </p>
        <hr>
    </div>

    <div id="about-grid">
        <div id='about-wrapper' >
            <img src="{{asset("images/kapil.jpg")}}" alt="" style="height: 250px; width: 250px; overflow: hidden;">

            <div class="slide-right-on-scroll">
                <h1 style="font-size: 24px; text-align: center;">Kapil Mulay</h1>
            </div>
            <div className='align-center'>
                <p>
                  Hi everyone! I am Kapil Mulay. Heavily passionate about technology, I seek to solve real-world problems with groundbreaking technological innovations.
                </p>
            </div>
        </div>

        <div id='about-wrapper' >
            <img src="{{asset("images/pranav.jpeg")}}" alt="" style="height: 250px; width: 250px; overflow: hidden;">
            <div class="slide-left-on-scroll">
                <h1 style="font-size: 24px; width: max-content; text-align: center;">Pranav Gurav</h1>
            </div>
            <div className='align-center'>
                <p>
                    Hey everyone! I'm Pranav Gurav. I believe in leadership, taking action and creating something that represents you.  
                </p>
            </div>
        </div>
    </div>


    <div id="FAQ-container">
        <div class="slide-right">
            <h1 style="width: 500px">FAQ</h1>
        </div>
        <div class="faq">
            <p class="question">
                Q. What is Grabbit?
            </p>
            <p class="answer">
                A. Grabbit is  a comprehensive e-commerce platform for all your needs, from things of daily requirement like dairy products and groceries to electronics and hardware, envisioned to revolutionize the online shopping experience.
            </p>
        </div>
        <div class="faq">
            <p class="question">
                Q. How do I promote my shop at Grabbit?
            </p>
            <p class="answer">
                A. You can promote your business by simply adding your store to our interface by simply logging on to our system and using certain options to add to our website/app  
            </p>
        </div>
        <div class="faq">
            <p class="question">
                Q. How do you sell advertising at Grabbit?
            </p>
            <p class="answer">
                A. We mainly focus on simplicity and convenience for the producer as well as the customer. You can simply mail us for franchising and advertising at grabbit123go@gmail.com.
            </p>
        </div>
        <div class="faq">
            <p class="question">
                Q. How do I make it easier for my customers to find my produce? 
            </p>
            <p class="answer">
                A. The process of searching and finding produce is algorithm-based, we give preference to items which are closer as well as economically viable to the customer.
            </p>
        </div>
        <div class="faq">
            <p class="question">
                Q. How do you estimate the reviews for the produce and the shops?
            </p>
            <p class="answer">
                A. The review system is based mainly on the quality of service you provide to us.
            </p>
        </div>
        <div class="faq">
            <p class="question">
                Q. How do I fix typographical errors on my product details?
            </p>
            <p class="answer">
                A. You can simply remove the undesired typographical errors by clicking on the edit button on the shop/produce section in the provider's app.
            </p>
        </div>
        <div class="faq">
            <p class="question">
                Q. Why are some products discounted while others are not?
            </p>
            <p class="answer">
                A. The majority produce is manufactured locally and as we promote local businesses we keep it our top priority, hence we offer a discount for the locally produced good.
            </p>
        </div>
        <div class="faq">
            <p class="question">
                Q. Do you have any store locations?
            </p>
            <p class="answer">
                A. We are always available online, and keep you our top priority 24*7.
            </p>
        </div>
        <div class="faq">
            <p class="question">
                Q. What carrier do you use for shipping?
            </p>
            <p class="answer">
                A. We use our own delivery partners and services for deliveries and distribution.
            </p>
        </div>
    </div>
@endsection