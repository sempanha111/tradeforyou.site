@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Frequently Asked Questions</h1>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="social">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="inside_wrap">
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 faq_wrap">





            <a href="#demo0002" class="faq" data-toggle="collapse">Where is the company located?</a>
            <div id="demo0002" class="collapse">Our office location: Portlethen, Aberdeen, Scotland, AB12 4UN</div>






            <a href="#demo001" class="faq" data-toggle="collapse">I made a Bitcoin withdrawal, it was processed
                instantly, but the transaction hash in blockchain doesn't exist! I'm seeing the message:
                "Transaction not found". Why? </a>
            <div id="demo001" class="collapse">

                That is blockchain issue, which is normal and happens sometimes. Just wait few moments and it will
                appear in your wallet.


            </div>




            <a href="#demo01" class="faq" data-toggle="collapse">I made a withdrawal, it was processed instantly,
                but it still doesn't appear in my wallet. Why? </a>
            <div id="demo01" class="collapse">Because you must always wait until 3 confirmations before it appears
                in your wallet, and it only depends on the speed of the cryptocurrency network. For example in
                Bitcoin, these links are very useful for you: <a href="https://www.blockchain.com/btc/tx"
                    target="_blank">https://www.blockchain.com/btc/tx</a> and <a
                    href="https://www.blockchain.com/btc/unconfirmed-transactions"
                    target="_blank">https://www.blockchain.com/btc/unconfirmed-transactions</a>. </div>


            <a href="#demo011" class="faq" data-toggle="collapse">I made a withdrawal, but it was not processed
                instantly. Why? </a>
            <div id="demo011" class="collapse">That's because you forgot to fill in your withdrawal addresses. Click
                on "Edit Account" button in your account menu and fill in your wallet information, where you would
                like to receive withdrawals. You must do it, because without this information your withdrawal won't
                be processed. </div>

            <a href="#demo012" class="faq" data-toggle="collapse">I made a deposit from my cryptocurrency wallet,
                but it still isn't credited to my Trade30Minutes account. Why? </a>
            <div id="demo012" class="collapse">Because you must always wait until 3 confirmations before it's
                credited to your Trade30Minutes account, and it only depends on the speed of the cryptocurrency
                network. For example in Bitcoin, these links are very useful for you: <a
                    href="https://www.blockchain.com/btc/tx" target="_blank">https://www.blockchain.com/btc/tx</a>
                and <a href="https://www.blockchain.com/btc/unconfirmed-transactions"
                    target="_blank">https://www.blockchain.com/btc/unconfirmed-transactions</a>. </div>


            <a href="#demo02" class="faq" data-toggle="collapse">What is the maximum deposit amount that I can make
                in Trade30Minutes?</a>
            <div id="demo02" class="collapse">There is no maximum limit, because you can make an unlimited number of
                deposits. We only have upto 1000 USD limit for each deposit separately. </div>





            <a href="#demo04" class="faq" data-toggle="collapse">What are the investment plans offered by
                Trade30Minutes?</a>
            <div id="demo04" class="collapse">Trade30Minutes offers 5 investment plans to all its investors,that is
                located on our website homepage and on account section(deposit menu)</div>










            <a href="#demo1" class="faq" data-toggle="collapse">What is Trade30Minutes, and what are the activities
                of the company?</a>
            <div id="demo1" class="collapse">Trade30Minutes is a prominent representative of the international
                financial market, cryptocurrency trading and mining, it is a developer of hardware and offers safe
                investments in this area.</div>



            <a href="#demo2" class="faq" data-toggle="collapse">Is Trade30Minutes a registered and legal
                company?</a>
            <div id="demo2" class="collapse">Yes, Trade30Minutes is registered in the United Kingdom as "Doublebull
                Limited" with a registration number of #02691387.</div>
            <a href="#demo3" class="faq" data-toggle="collapse">Who can be your customer?</a>
            <div id="demo3" class="collapse">Any interested person can become the investor of Trade30Minutes, no
                matter how well he or she understands the scope of our business and technical aspects of
                cryptocurrency mining as a whole.</div>
            <a href="#demo4" class="faq" data-toggle="collapse">Is your business established for a long term?</a>
            <div id="demo4" class="collapse">The company develops long-term relationships with customers and
                partners. Our business plan includes the phased development over the next 10 years, until at least
                2029.</div>
            <a href="#demo5" class="faq" data-toggle="collapse">Can I lose money by investing here?</a>
            <div id="demo5" class="collapse">No, you can't lose money. We make every effort to ensure the safety of
                your assets. Also we have a reserve fund, that ensures the safety of your deposits.</div>
            <a href="#demo6" class="faq" data-toggle="collapse">How do I open my Trade30Minutes account?</a>
            <div id="demo6" class="collapse">It's quite easy and convenient. Follow this <a href="?a=signup"
                    target="_blank">link</a>, fill in the registration form and then press "Register".</div>
            <a href="#demo7" class="faq" data-toggle="collapse">How can I make a deposit? </a>
            <div id="demo7" class="collapse">In the "Make Deposit" section of your account, select the necessary
                investment plan, enter the amount, select the payment source (send the amount from your wallet or
                invest from your account balance) and click on Spend button. </div>
            <a href="#demo8" class="faq" data-toggle="collapse">What payment tool can I use for investments and
                earnings?</a>
            <div id="demo8" class="collapse">
                We accept TON, Usdt, Tron, Bitcoin, Litecoin, Bitcoin Cash, Ethereum, Dogecoin and Binance Coin.
            </div>
            <a href="#demo9" class="faq" data-toggle="collapse">I wish to invest with Trade30Minutes but I don't
                have a cryptocurrency address. Where can I register it?</a>
            <div id="demo9" class="collapse">

                If you are not familiar with cryptocurrencies, then the easiest and most popular way is to use
                Bitcoin. You can invest with any service which is the provider of Bitcoin wallets (addresses). If
                you do not have such wallet, please register it at the following address <a
                    href="https://login.blockchain.com/#/signup" target="_blank" class="hrefclass"> Blockchain.info
                </a> or <a href="https://www.coinbase.com/signup" target="_blank"> Coinbase.com </a> or <a
                    href="https://block.io/users/sign_up" target="_blank"> Block.io </a>.


            </div>
            <a href="#demo10" class="faq" data-toggle="collapse">When registering I am asked to enter a
                Bitcoin/Litecoin/Bitcoin Cash/Ethereum/Dogecoin/Dash address. What is that?</a>
            <div id="demo10" class="collapse">Lets look at the example with Bitcoin. Bitcoin address is your ID
                (account, wallet number), starting with 1 or 3 and containing 27-34 alphanumeric Latin characters
                (other than 0, O, I). The address can also be represented as a QR-code, it is anonymous and does not
                contain information about the owner. For example, 1HQWcQxn3M8mGC1kKupqZdQB4Cc4HddB4B. Other
                cryptocurrencies have slightly different addresses but the main idea is similar to Bitcoin example.
            </div>
            <a href="#demo11" class="faq" data-toggle="collapse">How do I know the current BitCoin exchange
                rate?</a>
            <div id="demo11" class="collapse">Use any online converter to find out about the actual value of
                Bitcoin. The most popular service is <a class="hrefclass" href="https://preev.com"
                    target="_blank">https://preev.com</a> </div>
            <a href="#demo13" class="faq" data-toggle="collapse">Where can I buy BitCoin? </a>
            <div id="demo13" class="collapse">

                You can find cryptocurrency sellers here: <a href="https://www.buybitcoinworldwide.com"
                    target="_blank">BuyBitcoinWorldwide.com</a>

            </div>
            <a href="#demo14" class="faq" data-toggle="collapse">How much can I invest here?</a>
            <div id="demo14" class="collapse">
                Each of your deposits can be from 12 USD to 1000 USD maximum. The number of deposits is not limited.
            </div>
            <a href="#demo15" class="faq" data-toggle="collapse">I made a mistake during the registration and
                entered an incorrect email. How to fix it?</a>
            <div id="demo15" class="collapse">You cannot. You can not change your username or email. The only
                solution is to re-register your account.</div>
            <a href="#demo16" class="faq" data-toggle="collapse">How fast will my deposit be credited into my
                account?</a>
            <div id="demo16" class="collapse">Your deposit will be added after 3 confirmations of cryptocurrency
                network. This process takes from 1 to 24 hours. If you still don't know what Bitcoin confirmations
                are visit this site and read information here: <a class="hrefclass"
                    href="https://bitcoinsimplified.org/learn-more/confirmations"
                    target="_blank">https://bitcoinsimplified.org/learn-more/confirmations</a></div>
            <a href="#demo17" class="faq" data-toggle="collapse">What is BitCoin (or any other cryptocurrency)
                confirmation?</a>
            <div id="demo17" class="collapse">All BitCoin operations are confirmed by a BitCoin network. Every
                single computer in the BitCoin network confirms your transaction, increasing the total number of
                confirmations. When the number of confirmations reaches a specific threshold, usually from 3 to 6,
                the funds appear in the recipient account. Usually, such process takes up to 90 minutes.</div>
            <a href="#demo18" class="faq" data-toggle="collapse">What if after 6 confirmations my active deposit
                equals 0?</a>
            <div id="demo18" class="collapse">Address the technical support service via the feedback form in the
                "Support" section or via admin@Trade30Minutes and send the following data: 1) your login, 2) the
                exact amount of the deposit in Bitcoin, and 3) the address, to which the payment was sent.</div>
            <a href="#demo19" class="faq" data-toggle="collapse">How many deposits can I have simultaneously?</a>
            <div id="demo19" class="collapse">You can have many deposits, we do not limit their number. Each of your
                deposits has unique conditions, proper time of profit accrual and profit margins.</div>
            <a href="#demo20" class="faq" data-toggle="collapse">When will the first profit be generated?</a>
            <div id="demo20" class="collapse">Profit is generated on a daily basis, the first accrual will be the
                next day, after full 24 hours if you choose "AFTER" investment plans.</div>
            <a href="#demo21" class="faq" data-toggle="collapse">Do I get profit every day, even on weekends?</a>
            <div id="demo21" class="collapse">Yes, of course. Profit is generated on an ongoing basis, 7 days a
                week.</div>
            <a href="#demo22" class="faq" data-toggle="collapse">Do you make payments on weekends?</a>
            <div id="demo22" class="collapse">Yes, profits are also accrued on Saturdays and Sundays.</div>
            <a href="#demo23" class="faq" data-toggle="collapse">Is there a possibility of automatic reinvestment of
                profits (compounding)?</a>
            <div id="demo23" class="collapse">No, compounding is not provided. You have to reinvest manually from
                account balance.</div>
            <a href="#demo24" class="faq" data-toggle="collapse">Can I make a deposit directly from my balance or
                shall I first withdraw the funds?</a>
            <div id="demo24" class="collapse">Our system allows you to accumulate funds on the balance of your
                account, which you can use as a source for the creation of a new deposit.</div>
            <a href="#demo25" class="faq" data-toggle="collapse">How can I withdraw funds?</a>
            <div id="demo25" class="collapse">Login to your account using your username and password and click on
                "Withdraw Funds" section.</div>
            <a href="#demo26" class="faq" data-toggle="collapse">What is the minimum amount I can withdraw?</a>
            <div id="demo26" class="collapse">The minimum withdrawal amount is 1 USD.</div>
            <a href="#demo27" class="faq" data-toggle="collapse">After I make a withdrawal request, when will the
                funds be available on my BitCoin wallet?</a>
            <div id="demo27" class="collapse">The system works in an automatic mode, which means that you get paid
                immediately after creating your query.</div>
            <a href="#demo28" class="faq" data-toggle="collapse">What is the referral commission?</a>
            <div id="demo28" class="collapse">Trade30Minutes offers 2 levels of referral commissions - 10%
                commission for every deposit that your direct referral makes from his wallet, 2nd level commission
                is 3%.</div>
            <a href="#demo29" class="faq" data-toggle="collapse">Do I have to have my own deposit in order to
                receive referral commissions?</a>
            <div id="demo29" class="collapse">
                No, it is not necessary to have your own active deposit.
            </div>
            <a href="#demo30" class="faq" data-toggle="collapse">I can't enter my account! What to do?</a>
            <div id="demo30" class="collapse">Check the login data: your username and password. If you are sure you
                enter correct data, but it is not possible to access the account, use the password reset function,
                which is located below the login form. Click on <a href="?a=forgot_password" target="_blank">forgot
                    password</a> link, type your username or e-mail and you'll receive a confirmation code to your
                email for resetting your password.</div>
            <a href="#demo31" class="faq" data-toggle="collapse">How can I change my password?</a>
            <div id="demo31" class="collapse">You can change your password directly from your members area by
                editing it in your personal profile.</div>
            <a href="#demo32" class="faq" data-toggle="collapse">How can I add my wallet addresses to my
                account?</a>
            <div id="demo32" class="collapse">You can always add/edit your wallet address in "Edit Account" section.
            </div>
            <a href="#demo33" class="faq" data-toggle="collapse">I don't receive emails from the company! Why?</a>
            <div id="demo33" class="collapse">Check the spam folder in your mailbox. If the problem is not solved,
                contact your email provider. We strongly recommend that you use the service @gmail.com to work with
                the website.</div>
            <a href="#demo34" class="faq" data-toggle="collapse">How can I check my account balances?</a>
            <div id="demo34" class="collapse">You can access the account information 24 hours, seven days a week
                over the Internet.</div>
            <a href="#demo35" class="faq" data-toggle="collapse">May I open several accounts in your program?</a>
            <div id="demo35" class="collapse">Yes, but we strongly recommend that you register one account and use
                it for investment. It will allow to reduce load on the server and database, as well as prevent any
                possible problems.</div>
            <a href="#demo36" class="faq" data-toggle="collapse">Can my relatives register from my IP address?</a>
            <div id="demo36" class="collapse">Yes, sure.</div>

            <a href="#demo39" class="faq" data-toggle="collapse">I made a request to withdraw profit, but it is
                pending! What to do?</a>
            <div id="demo39" class="collapse">
                The most likely cause of the payment delay is invalid payment address in your "Edit Account"
                section, or its absence, check it out first.
            </div>
            <a href="#demo40" class="faq" data-toggle="collapse">How can I cancel a payment?</a>
            <div id="demo40" class="collapse">You can do it yourself in the Withdrawals History section by clicking
                [cancel].</div>
            <a href="#demo41" class="faq" data-toggle="collapse">My withdrawal request is processed, but the amount
                did not get in my wallet. Why?</a>
            <div id="demo41" class="collapse">All cryptocurrency transactions are processed after 3 network
                confirmations. Just wait, it shouldn't take more than 24 hours maximum.</div>
            <a href="#demo42" class="faq" data-toggle="collapse">How can I contact you in case of problems on the
                website?</a>
            <div id="demo42" class="collapse">You can contact us around the clock via the support form or email
                admin@Trade30Minutes. We will promptly respond to any problems.</div>
            <a href="#demo43" class="faq" data-toggle="collapse">Do you charge any fees to withdraw funds?</a>
            <div id="demo43" class="collapse">No, our clients do not have to bear any fees while withdrawing their
                funds.</div>
            <a href="#demo44" class="faq" data-toggle="collapse">What do I need to do to earn referral
                commissions?</a>
            <div id="demo44" class="collapse">You just need to register and use your referral link to attract new
                investors.</div>

            <a href="#demo46" class="faq" data-toggle="collapse">What is fixed rate for cryptocurrency and why do we
                need it?</a>
            <div id="demo46" class="collapse">Our company has a fixed rate for deposits. It is done to protect you
                from volatility on cryptocurrency market. This means that you will always receive your profit and
                will not depend on the market price. With our fixed rate you don't need to worry about rapid changes
                of cryptocurrency value on the market. You will receive exactly as much Bitcoin (or any other
                cryptocurrency) as you should receive depending on the deposit interest rate.</div>
        </div>
    </div>
</div>

@endsection
