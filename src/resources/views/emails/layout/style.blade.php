<style>
    * {
        margin: 0;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        box-sizing: border-box;
        font-size: 14px;
    }

    img {
        max-width: 100%;
    }

    body {
        -webkit-font-smoothing: antialiased;
        -webkit-text-size-adjust: none;
        width: 100% !important;
        height: 100%;
        line-height: 1.6em;
    }

    table td {
        vertical-align: top;
    }

    body {
        background-color: #ecf0f5;
        color: #6c7b88
    }

    .body-wrap {
        background-color: #ecf0f5;
        width: 100%;
    }

    .container {
        display: block !important;
        max-width: 1600px !important;
        margin: 0 auto !important;
        /* makes it centered */
        clear: both !important;
    }

    .content {
        max-width: 600px;
        margin: 0 auto;
        display: block;
        padding: 20px;
    }

    .main {
        background-color: #fff;
        border-bottom: 2px solid #d7d7d7;
    }

    .content-wrap {
        padding: 20px;
    }

    .content-block {
        padding: 0 0 20px;
    }

    .header {
        width: 100%;
        margin-bottom: 20px;
    }

    .footer {
        width: 100%;
        clear: both;
        color: #999;
        padding: 20px;
    }
    .footer p, .footer a, .footer td {
        color: #999;
        font-size: 12px;
    }

    h1, h2, h3 {
        font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
        color: #1a2c3f;
        margin: 30px 0 0;
        line-height: 1.2em;
        font-weight: 400;
    }

    h1 {
        font-size: 32px;
        font-weight: 500;
    }

    h2 {
        font-size: 24px;
    }

    h3 {
        font-size: 18px;
    }

    h4 {
        font-size: 14px;
        font-weight: 600;
    }

    p, ul, ol {
        margin-bottom: 10px;
        font-weight: normal;
    }
    p li, ul li, ol li {
        margin-left: 5px;
        list-style-position: inside;
    }

    a {
        color: #348eda;
        text-decoration: underline;
    }

    .btn-primary {
        text-decoration: none;
        color: #FFF;
        background-color: #42A5F5;
        border: solid #42A5F5;
        border-width: 10px 20px;
        line-height: 2em;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        display: inline-block;
        text-transform: capitalize;
    }

    .last {
        margin-bottom: 0;
    }

    .first {
        margin-top: 0;
    }

    .aligncenter {
        text-align: center;
    }

    .alignright {
        text-align: right;
    }

    .alignleft {
        text-align: left;
    }

    .clear {
        clear: both;
    }

    .alert {
        font-size: 16px;
        color: #fff;
        font-weight: 500;
        padding: 20px;
        text-align: center;
    }
    .alert a {
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        font-size: 16px;
    }
    .alert.alert-warning {
        background-color: #FFA726;
    }
    .alert.alert-bad {
        background-color: #ef5350;
    }
    .alert.alert-good {
        background-color: #8BC34A;
    }

    .invoice {
        margin: 25px auto;
        text-align: left;
        width: 100%;
    }
    .invoice td {
        padding: 5px 0;
    }
    .invoice .invoice-items {
        width: 100%;
    }
    .invoice .invoice-items td {
        border-top: #eee 1px solid;
    }
    .invoice .invoice-items .total td {
        border-top: 2px solid #6c7b88;
        font-size: 18px;
    }

    @media only screen and (max-width: 640px) {
        body {
            padding: 0 !important;
        }

        h1, h2, h3, h4 {
            font-weight: 800 !important;
            margin: 20px 0 5px !important;
        }

        h1 {
            font-size: 22px !important;
        }

        h2 {
            font-size: 18px !important;
        }

        h3 {
            font-size: 16px !important;
        }

        .container {
            padding: 0 !important;
            width: 100% !important;
        }

        .content {
            padding: 0 !important;
        }

        .content-wrap {
            padding: 10px !important;
        }

        .invoice {
            width: 100% !important;
        }
    }

</style>
