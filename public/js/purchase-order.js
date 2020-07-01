
$(document).ready(function() {
    // $('.customers').select2();

    $('.supplier').select2({
        ajax: {
            url: window.location.origin + "/users/suppliers",
            dataType: 'json',
            processResults: function (data) {
                console.log(data);
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data
                };
            }
        } }
    );
    console.log("supplier");
});

new Vue({
    el: '.purchase-order',
    data:{
        purchase_order_rows: [],
        order_id: order_id
    },
    mounted: function(){

        this.getAllPurchasedLine();
    },
    methods:{

        getAllPurchasedLine: function(){

            let vm = this;

            axios.get(window.location.origin + "/orders/purchased/"+this.order_id+"/lines").then(function(response){

                response.data.forEach(function(line, index){
                    vm.purchase_order_rows.push({
                        quantity: line.quantity,
                        sku: line.product.sku,
                        product_id: line.product.id,
                        product_name: line.product.name,
                        batch: line.batch,
                        expire_date: line.expire_date,
                        index: index
                    });

                    window.setTimeout(function(){
                        vm.renderDateRangePicker(index, line.expire_date);
                        vm.renderSelect2(index);
                    }, 100);
                });
            });
        },
        removePurchaseOrder: function(index){

            this.purchase_order_rows.splice(index, 1);

        },
        testMe: function(index){
            console.log(index);
        },
        renderSelect2: function(index){

            let repo_global = "",
                vm = this;
            jQuery('#product_'+index).select2({
                ajax: {
                    url: window.location.origin + "/products",
                    width: 'resolve',
                    dataType: 'json',
                    processResults: function (data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data
                        };
                    }
                },
                templateSelection: function(repo){
                    repo_global = repo;
                    // console.log(repo);
                    return repo.text || repo.id;
                }
            }).on('change', function(e){
                let index = jQuery(this).attr("id").split("_")[1];
                vm.purchase_order_rows[index].sku = repo_global.sku;
            });
        },
        renderDateRangePicker: function(index, startDate){

            let vm = this,
                dateRangePicker = {
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                };


            startDate !== undefined  && startDate != null ? dateRangePicker.startDate = startDate : '';

            $('#expire_date_'+index).daterangepicker(dateRangePicker,
                function(date) {
                    let index = jQuery(this.element[0]).attr("id").split("_")[2];
                    vm.purchase_order_rows[index].expire_date = date.format('YYYY-MM-DD');
                }
            );
        },
        AddPurchaseOrder: function(e){

            e.preventDefault();

            let index = this.purchase_order_rows.length;
            this.purchase_order_rows.push({
                quantity: 1,
                sku: '',
                name: '',
                batch: '',
                expire_date: '',
                index: index
            });

            let vm = this;

            // const year = new Date();
            // const START_DATE = year.getFullYear()+"-01-01";
            // const END_DATE = year.getFullYear() + "-"+ ('0' + year.getMonth()).slice(-2) + "-" + year.getDate();

            window.setTimeout(function(){

                vm.renderSelect2(index);
                vm.renderDateRangePicker(index);

            }, 300);
        }
    }
})

