<?php include './includes/header.php' ?>


   <div class="accounts-main-container signup-frm">
        <div class="header-section-accounts">
            <h1>Create Account</h1>
        </div>

        <form action="/inviteme/app/createcustomer.php" method="POST">
            <div class="accounts-form-section">
                <label for="uemail">Email</label>
                <br>
                <input type="email" name="uemail" id="uemail" placeholder="e.g. myemail@example.com">
            </div>

            <div class="accounts-form-section">
                <label for="uemail2">Confirm Email</label>
                <br>
                <input type="email" name="uemail2" id="uemail2" placeholder="e.g. myemail@example.com">
                <div class="msg-box" id="msg-box-email2">
                   
                </div>
            </div>

            <div class="accounts-form-section">
                <label for="addr">Address</label>
                <br>
                <input type="text" name="addr" id="addr" placeholder="e.g. Line 1, Line 2">
                <div class="msg-box" id="msg-box-addr">
                    
                </div>
            </div>

            <div class="accounts-form-section">
                <label for="country">Country</label>
                <br>
                <input type="text" name="country" id="country" placeholder="e.g. Kenya">
                <div class="msg-box" id="msg-box-country">
                   
                </div>
            </div>

            <div class="accounts-form-section">
                <label for="reg">Region</label>
                <br>
                <input type="text" name="reg" id="reg" placeholder="e.g. Africa">
                <div class="msg-box" id="msg-box-region">
                   
                </div>
            </div>

            <div class="accounts-form-section">
                <label for="uphone">Phone</label>
                <br>
                <input type="text" name="uphone"  id="uphone" placeholder="e.g. 2547xx xxx758">
                <div class="msg-box" id="msg-box-phone">
                    
                </div>
            </div>

            

            <div class="accounts-form-section">
                <label for="orgname">Organization or Institution</label>
                <br>
                <input type="text" name="orgname"  id="orgname" placeholder="e.g. Wilson & Sons Inc.">
                
            </div>

            <div class="accounts-form-section">
                <label for="orgpost">Role</label>
                <br>
                <input type="text" name="orgpost"  id="orgpost" placeholder="e.g. Marketing Manager">
                
            </div>

            <div class="accounts-form-section">
                <label for="upass">Password</label>
                <br>
                <input type="password" name="upass"  id="upass" placeholder=".......">
            </div>

            <div class="accounts-form-section">
                <label for="upass2">Confirm Password</label>
                <br>
                <input type="password" name="upass2"  id="upass2" placeholder=".......">
                <div class="msg-box" id="msg-box-pass2">
                    
                </div>
            </div>

            <div class="accounts-form-section btn-section">
                <button type="submit">Sign Up</button>
            </div>
        </form>
   </div>

   <script>
        //all fields
        const address = document.getElementById('addr')
        const country = document.getElementById('country')
        const region = document.getElementById('reg')
        const phone = document.getElementById('uphone')
        const email = document.getElementById('uemail')
        const email2 = document.getElementById('uemail2')
        const password = document.getElementById('upass')
        const password2 = document.getElementById('upass2')
       

        //all field messages

        const email_msg = document.getElementById('msg-box-email2')
        const addr_msg = document.getElementById('msg-box-addr')
        const country_msg = document.getElementById('msg-box-country')
        const region_msg = document.getElementById('msg-box-region')
        const phone_msg = document.getElementById('msg-box-phone')
        const password2_msg = document.getElementById('msg-box-pass2')

        //event listeners and functions

        email2.addEventListener('input',()=>{
            if(email2.value != email.value){
                email_msg.innerHTML = '<p class="fail"><i class="fa fa-circle-xmark"></i> Email is invalid.</p>';
            }else{
                email_msg.innerHTML = '<p class="success"><i class="fa fa-check-circle"></i> Email matches.</p>';
            }
        })

        address.addEventListener('input',()=>{
            if(address.value.length < 11){
                addr_msg.innerHTML = '<p class="fail"><i class="fa fa-circle-xmark"></i> Address cannot be less than 11 characters.</p>';
            }else{
                addr_msg.innerHTML = '<p class="success"><i class="fa fa-check-circle"></i> Address is valid.</p>';
            }
        })

        country.addEventListener('input',()=>{
            if(country.value.length < 5){
                country_msg.innerHTML = '<p class="fail"><i class="fa fa-circle-xmark"></i> The country name has to be more than 4 characters.</p>';
            }else{
                country_msg.innerHTML = '<p class="success"><i class="fa fa-check-circle"></i> country name is valid.</p>';
            }
        })

        region.addEventListener('input',()=>{
            if(region.value.length < 5){
                region_msg.innerHTML = '<p class="fail"><i class="fa fa-circle-xmark"></i> The region name has to be more than 4 characters.</p>';
            }else{
                region_msg.innerHTML = '<p class="success"><i class="fa fa-check-circle"></i> Region name is valid.</p>';
            }
        })

        phone.addEventListener('input',()=>{
            if(phone.value.length != 12){
                phone_msg.innerHTML = '<p class="fail"><i class="fa fa-circle-xmark"></i>Your phone number needs to be 12 numbers.</p>';
            }else{
                phone_msg.innerHTML = '<p class="success"><i class="fa fa-check-circle"></i> Your phone number is valid.</p>';
            }
        })

        phone.addEventListener('input',()=>{
            if(phone.value.length != 12){
                phone_msg.innerHTML = '<p class="fail"><i class="fa fa-circle-xmark"></i>Your phone number needs to be 12 numbers.</p>';
            }else{
                phone_msg.innerHTML = '<p class="success"><i class="fa fa-check-circle"></i> Your phone number is valid.</p>';
            }
        })

        password2.addEventListener('input',()=>{
            if(password2.value != password.value){
                password2_msg.innerHTML = '<p class="fail"><i class="fa fa-circle-xmark"></i>Your password does not match.</p>';
            }else{
                password2_msg.innerHTML = '<p class="success"><i class="fa fa-check-circle"></i> Your password is valid.</p>';
            }
        })

   </script>

   <?php  include './includes/footer.php' ?>
