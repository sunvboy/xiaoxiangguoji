@push('javascript')
<script>
    $(document).on('click', '.js_addHotline', function(e) {
        var html = '';
        html += '<div class="flex space-x-3">';
        html += '<input class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Điện thoại" name="hotline[]" type="text" value="">';
        html += '<button type="button" class="js_removeHotline text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">';
        html += '<i class="fa-solid fa-trash"></i>'
        html += '</button>'
        html += '</div>'
        $('#htmlHotline').append(html)
        checkLengthHotline()
    })
    $(document).on('click', '.js_removeHotline', function(e) {
        e.preventDefault()
        $(this).parent().remove()
        checkLengthHotline()
    })

    function checkLengthHotline() {
        var lengthHotline = $('#htmlHotline>div').length;
        console.log(lengthHotline)
        if (!lengthHotline) {
            $('.js_addHotline').removeClass('mt-2')
        } else {
            $('.js_addHotline').addClass('mt-2')
        }
    }
    //website
    $(document).on('click', '.js_addWebsite', function(e) {
        var html = '';
        html += '<div class="flex space-x-3">';
        html += '<input class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Website" name="website[]" type="text" value="">';
        html += '<button type="button" class="js_removeWebsite text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">';
        html += '<i class="fa-solid fa-trash"></i>'
        html += '</button>'
        html += '</div>'
        $('#htmlWebsite').append(html)
        checkLengthWebsite()
    })
    $(document).on('click', '.js_removeWebsite', function(e) {
        e.preventDefault()
        $(this).parent().remove()
        checkLengthWebsite()
    })

    function checkLengthWebsite() {
        var lengthWebsite = $('#htmlWebsite>div').length;
        if (!lengthWebsite) {
            $('.js_addWebsite').removeClass('mt-2')
        } else {
            $('.js_addWebsite').addClass('mt-2')
        }
    }
    //email
    $(document).on('click', '.js_addEmail', function(e) {
        var html = '';
        html += '<div class="flex space-x-3">';
        html += '<input class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Email" name="email[]" type="text" value="">';
        html += '<button type="button" class="js_removeEmail text-white flex-1 bg-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">';
        html += '<i class="fa-solid fa-trash"></i>'
        html += '</button>'
        html += '</div>'
        $('#htmlEmail').append(html)
        checkLengthEmail()
    })
    $(document).on('click', '.js_removeEmail', function(e) {
        e.preventDefault()
        $(this).parent().remove()
        checkLengthEmail()
    })

    function checkLengthEmail() {
        var lengthEmail = $('#htmlEmail>div').length;
        if (!lengthEmail) {
            $('.js_addEmail').removeClass('mt-2')
        } else {
            $('.js_addEmail').addClass('mt-2')
        }
    }
</script>
@endpush