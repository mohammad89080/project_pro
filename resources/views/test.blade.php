
<td>
                                            <div class="dropdown" x-data="{
                        loading : false,
                        id: '6437539d-6c03-4eb0-bab7-c1d28ebfb162',
                        ip: '',
                        designationId : '327e75d8-671d-458e-8742-f00bec0469bc',
                        last_in_time : '',
                        auto_punch_out_time : '',
                        lazySlideLoad : function(index, slide){
                            if(!$.trim($('#'+index+'-6437539d-6c03-4eb0-bab7-c1d28ebfb162').html()).length){
                                this.loading = index;
                                axios.get('https://www.kingpabel.com/attendance-management-system/partial/user-slide',{
                                    params : {
                                        id : this.id,
                                        slide : index,
                                        ip : this.ip,
                                        designationId : this.designationId,
                                        last_in_time : this.last_in_time,
                                        auto_punch_out_time : this.auto_punch_out_time
                                    }
                                })
                                .then(({data})=> {
                                    this.loading = false;
                                    $('#'+index+'-6437539d-6c03-4eb0-bab7-c1d28ebfb162').html(data);
                                    $('#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162').carousel(slide);
                                })
                            }else{
                                $('#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162').carousel(slide);
                            }
                        }
                    }">
    <button type="button" id="dropdownMenu_6437539d-6c03-4eb0-bab7-c1d28ebfb162" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-primary btn-sm dropdown-toggle">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-wrench" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019L13 11l-.471.242-.529.026-.287.445-.445.287-.026.529L11 13l.242.471.026.529.445.287.287.445.529.026L13 15l.471-.242.529-.026.287-.445.445-.287.026-.529L15 13l-.242-.471-.026-.529-.445-.287-.287-.445-.529-.026z"></path>
        </svg>
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
        <form>
            <div id="carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162" class="carousel menu-resolver">
                <div class="carousel-inner" id="carousel-inner-6437539d-6c03-4eb0-bab7-c1d28ebfb162">

                    <div class="carousel-item active">
                        <a class="dropdown-item" data-slide-to="99" x-on:click.prevent="lazySlideLoad('ip-restriction-slide', 1)" href="#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                            <i x-show="loading == 'ip-restriction-slide'" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></i>
                            <i class="mdi mdi-ip-network-outline"></i> IP Restriction
</a>

                        <a class="dropdown-item" data-slide-to="99" x-on:click.prevent="lazySlideLoad('update-password-slide', 2)" href="#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                            <i x-show="loading == 'update-password-slide'" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></i>
                            <i class="mdi mdi-account-key-outline"></i> Update Password
</a>

                        <a class="dropdown-item" data-slide-to="99" x-on:click.prevent="lazySlideLoad('update-designation-slide', 3)" href="#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                            <i x-show="loading == 'update-designation-slide'" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></i>
                            <i class="mdi mdi-account-tie-outline"></i> Update Designation
</a>

                                                <a class="dropdown-item" wire:click.prevent="statusUpdate(&quot;6437539d-6c03-4eb0-bab7-c1d28ebfb162&quot;)" href="#">
                            <i class="mdi mdi-account-check-outline"></i> Make Active</a>

                        <a class="dropdown-item" data-slide-to="99" x-on:click.prevent="lazySlideLoad('last-in-time-slide', 5)" href="#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                            <i x-show="loading == 'last-in-time-slide'" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></i>
                            <i class="mdi mdi-av-timer"></i> Last In Time
</a>

                        <a class="dropdown-item" data-slide-to="99" x-on:click.prevent="lazySlideLoad('auto-punch-out-time-slide', 6)" href="#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                            <i x-show="loading == 'auto-punch-out-time-slide'" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></i>
                            <i class="mdi mdi-timer"></i> Auto Punch Out Time
</a>

                        <a class="dropdown-item" data-slide-to="99" x-on:click.prevent="lazySlideLoad('force-punch-in-out-slide', 7)" href="#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                            <i x-show="loading == 'force-punch-in-out-slide'" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></i>
                            <i class="mdi mdi-progress-clock"></i> Force Punch In / Out
</a>

                        <a class="dropdown-item" href="https://www.kingpabel.com/attendance-management-system/user/6437539d-6c03-4eb0-bab7-c1d28ebfb162/force/login">
                            <i class="mdi mdi-account-convert"></i> Force Login
</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" data-slide-to="99" x-on:click.prevent="lazySlideLoad('delete-slide', 4)" href="#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                            <i x-show="loading == 'delete-slide'" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></i>
                            <i class="mdi mdi-account-remove-outline"></i> Delete
                        </a>
                    </div>

                    <div class="carousel-item required-action-section" id="ip-restriction-slide-6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                    </div>

                    <div class="carousel-item required-action-section" id="update-password-slide-6437539d-6c03-4eb0-bab7-c1d28ebfb162"><div x-data="{
    password: '',
    error: false,
    loading: false,
    update: function() {
        this.loading = true;
        this.error = false;
        axios.patch('https://www.kingpabel.com/attendance-management-system/user/6437539d-6c03-4eb0-bab7-c1d28ebfb162', {
            password: this.password })
            .then(({data}) => {
                this.loading = false;
                this.error = false;
                toastr.success('Password Updated Successfully', '', {progressBar : true});
                this.password='';
                $('#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162').carousel(0);
                $('#dropdownMenu_6437539d-6c03-4eb0-bab7-c1d28ebfb162').dropdown('hide');
            })
            .catch(({response}) => {
                this.loading = false;
                if(response.status == 422 &amp;&amp; (this.error = response.data.errors.password[0])){
                    toastr.error(this.error, '', {progressBar : true});
                }else{
                    toastr.error('Something Went Wrong. Try Again Later', '', {progressBar : true});
                }
            })
    }
}">
    <div class="required-action-section-header" data-target="#carousel_6437539d-6c03-4eb0-bab7-c1d28ebfb162" data-slide-to="0">
        <i class="fa fa-long-arrow-left arrow-previous"></i>
        <span class="required-action-section-heading">Set a New Password</span>
    </div>

    <div class="required-action-section-content pb-3">
        <input type="password" class="form-control" :class="{'is-invalid' : error, 'input-loading' : loading}" placeholder="Password..." x-model="password" @keydown.enter="update">
    </div>
    <button :disabled="loading" @click="update" type="button" class="btn btn-outline-info btn-lg btn-block required-action-section-button">
        <i class="mdi mdi-account-key-outline"></i>Update</button>
</div></div>

                    <div class="carousel-item required-action-section" id="update-designation-slide-6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                    </div>

                    <div class="carousel-item required-action-section" id="delete-slide-6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                    </div>

                    <div class="carousel-item required-action-section" id="last-in-time-slide-6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                    </div>

                    <div class="carousel-item required-action-section" id="auto-punch-out-time-slide-6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                    </div>

                    <div class="carousel-item required-action-section" id="force-punch-in-out-slide-6437539d-6c03-4eb0-bab7-c1d28ebfb162">
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>                                        </td>
