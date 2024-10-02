@extends('layouts.app', ['search' => $search ?? null])

@section('content')

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