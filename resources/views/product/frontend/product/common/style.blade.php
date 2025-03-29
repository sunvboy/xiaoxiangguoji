<style>
    .box_product_detail .disabled,
    .box_product_detail .checked {
        position: relative;
    }

    .box_product_detail .disabled:after {
        background-color: rgba(255, 255, 255, 0.3);
        background-image: url(https://asset.uniqlo.com/g/icons/chip_disabled.svg);
        background-position: top left;
        background-size: contain;
        bottom: 0;
        content: '';
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
    }

    .box_product_detail .disabled {
        color: #dbd6d6 !important;
    }

    .box_product_detail .checked {
        border-color: #d61c1f;
        color: #d61c1f;
    }



    input[type='number']::-webkit-inner-spin-button,
    input[type='number']::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .custom-number-input input:focus {
        outline: none !important;
    }

    .custom-number-input button:focus {
        outline: none !important;
    }
</style>