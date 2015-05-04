<?php
    
?>
<title>Welcome to My Site!</title>
<script>
    $(document).ready(function(){
        $('title').text('My Site - Portfolio');
        $('.link-group').click(function(){
            $('.sub-group').slideUp();
            if($(this).next('ul').is(':hidden')){
                $(this).next('ul').slideToggle();
            }
        });
    });
</script>
<div class="row" style="padding-top:15px;">
    <div class="col-lg-8" style="height:10000px;">
        <p style="text-align:justify;">As I am primarily a language agnostic web developer, I use a variety of software languages to attain the results that the current job calls for. Below I will post content that I have created in my personal endeavors that I feel show great example of my skills through various programming languages from PHP to Java, JavaScript to Angular. These will showcase the various development skills I have built over time and include links to github repositories.<span class="visible-lg" style="padding-top:15px;"> To the right is a navigation panel for the code snippets below.</span></p>
    </div>
    <div class="container visible-lg" style="position:fixed;">
        <div class="col-lg-4 col-lg-offset-8">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align:center;">
                    Quick Links
                </div>
                <ul class="list-group main-group" style="list-style-type:none;">
                    <a class="list-group-item list-group-item-info link-group">
                        <li>Test Group</li>
                    </a>
                    <ul class="list-group sub-group" style="list-style-type:none;padding-top:1px;margin-bottom:0px;display:none;">
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                    </ul>
                    <a class="list-group-item list-group-item-info link-group">
                        <li>Test Group</li>
                    </a>
                    <ul class="list-group sub-group" style="list-style-type:none;padding-top:1px;margin-bottom:0px;display:none;">
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                        <a class="list-group-item"><li>Test Link</li></a>
                    </ul>
                </ul>
                <div class="panel-footer">
                    
                </div>
            </div>
        </div>
    </div>
</div>