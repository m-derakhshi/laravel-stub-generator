<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CodePen Demo</title>
    <meta name="robots" content="noindex">
    <link rel="icon"
          href="data:image/svg+xml,%3Csvg style='color: red' role='img' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Ctitle%3ECodeIgniter%3C/title%3E%3Cpath d='M11.466 0c.88 1.423-.28 3.306-1.207 4.358-.899 1.02-1.992 1.873-2.985 2.8-1.066.996-2.091 2.044-2.967 3.213-1.753 2.339-2.827 5.28-2.038 8.199.788 2.916 3.314 4.772 6.167 5.429-1.44-.622-2.786-2.203-2.79-3.82-.003-1.765 1.115-3.262 2.505-4.246-.167.632-.258 1.21.155 1.774a1.68 1.68 0 0 0 1.696.642c1.487-.326 1.556-1.96.674-2.914-.872-.943-1.715-2.009-1.384-3.377.167-.685.588-1.328 1.121-1.787-.41 1.078.755 2.14 1.523 2.67 1.332.918 2.793 1.612 4.017 2.688 1.288 1.132 2.24 2.661 2.047 4.435-.208 1.923-1.736 3.26-3.45 3.936 3.622-.8 7.365-3.61 7.44-7.627.093-3.032-1.903-5.717-5.158-7.384.19.48.074.697-.058.924-.55.944-2.082 1.152-2.835.184-1.205-1.548.025-3.216.197-4.855.215-2.055-1.073-4.049-2.67-5.242z' fill='red'%3E%3C/path%3E%3C/svg%3E"
          type="image/svg+xml"/>

    <!-- https://codepen.io/anandaprojapati/pen/GmrwYE -->
    <style>
      body {
        font-family: Verdana, Geneva, sans-serif;
        font-size: 14px;
        background: #f2f2f2;
      }


      .form_wrapper {
        background: #fff;
        width: 50%;
        max-width: 100%;
        box-sizing: border-box;
        padding: 10px;
        margin: 30px auto 0;
        position: relative;
        z-index: 1;
        border-top: 5px solid #f5ba1a;
        -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
        -webkit-transform-origin: 50% 0%;
        transform-origin: 50% 0%;
        -webkit-transform: scale3d(1, 1, 1);
        transform: scale3d(1, 1, 1);
        -webkit-transition: none;
        transition: none;
        -webkit-animation: expand 0.8s 0.6s ease-out forwards;
        animation: expand 0.8s 0.6s ease-out forwards;
      }

      .form_wrapper h2 {
        font-size: 1.5em;
        line-height: 1.5em;
        margin: 0;
      }

      .form_wrapper .title_container {
        text-align: center;
        padding-bottom: 15px;
      }

      .form_wrapper h3 {
        font-size: 1.1em;
        font-weight: normal;
        line-height: 1.5em;
        margin: 0;
      }

      .form_wrapper label {
        font-size: 12px;
      }

      .form_wrapper .row {
        margin: 10px -15px;
      }

      .form_wrapper .row > div {
        padding: 0 15px;
        box-sizing: border-box;
      }

      .form_wrapper .col_half {
        width: 50%;
        float: left;
      }

      .form_wrapper .input_field {
        position: relative;
        margin-bottom: 10px;
        -webkit-animation: bounce 0.6s ease-out;
        animation: bounce 0.6s ease-out;
      }

      .form_wrapper input[type=text], .form_wrapper select, .form_wrapper input[type=email], .form_wrapper input[type=password] {
        width: 100%;
        padding: 8px 10px 9px;
        height: 35px;
        border: 1px solid #cccccc;
        box-sizing: border-box;
        outline: none;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
      }

      .form_wrapper input[type=text]:hover, .form_wrapper input[type=email]:hover, .form_wrapper input[type=password]:hover {
        background: #fafafa;
      }

      .form_wrapper input[type=text]:focus, .form_wrapper input[type=email]:focus, .form_wrapper input[type=password]:focus {
        -webkit-box-shadow: 0 0 2px 1px rgba(255, 169, 0, 0.5);
        -moz-box-shadow: 0 0 2px 1px rgba(255, 169, 0, 0.5);
        box-shadow: 0 0 2px 1px rgba(255, 169, 0, 0.5);
        border: 1px solid #f5ba1a;
        background: #fafafa;
      }

      .form_wrapper input[type=submit] {
        background: #f5ba1a;
        height: 35px;
        line-height: 35px;
        width: 100%;
        border: none;
        outline: none;
        cursor: pointer;
        color: #fff;
        font-size: 1.1em;
        margin-bottom: 10px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
      }

      .form_wrapper input[type=submit]:hover {
        background: #e1a70a;
      }

      .form_wrapper input[type=submit]:focus {
        background: #e1a70a;
      }


      .form_container .row .col_half.last {
        border-left: 1px solid #cccccc;
      }


      @media (max-width: 600px) {
        .form_wrapper .col_half {
          width: 100%;
          float: none;
        }

        .bottom_row .col_half {
          width: 50%;
          float: left;
        }

        .form_container .row .col_half.last {
          border-left: none;
        }

        .remember_me {
          padding-bottom: 20px;
        }
      }
    </style>
</head>
<body>
<div class="form_wrapper">
    <div class="title_container">
        <h2>Stub generator</h2>
    </div>
    <div class="input_field">
        <label>Source type:
            <select onchange="location.href='{{url('stub-generator')}}/'+this.value;">
                <option>-</option>
                @foreach($directoriesName as $itemName)
                    <option @if($itemName == $sourceType) selected="selected"
                            @endif value="{{$itemName}}">{{$itemName}}</option>
                @endforeach
            </select>
        </label>
    </div>
    @if(!is_null($sourceType))
        <form action="{{request()->url()}}" method="post">
            <div style="display:none" id="ajaxLoad"></div>
            @csrf
            <div class="input_field">
                <label>target:
                    <select onchange="$.post('{{request()->url()}}',{getFiles:true,targetDirectory:this.value},function(data, status, xhr) {eval(data);});"
                            name="targetDirectory">
                        @foreach($targetDirectories as $key=>$item)
                            <option @if($item['path'] == $targetPath) selected="selected"
                                    @endif value="{{$key}}">{{$item['namespace']}} => {{$item['path']}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="input_field">
                <label>Parent:
                    <select id=targetParent name="parent">
                        <option value="">-</option>
                        @foreach($destinationParents as $parentName)
                            <option @if($parentName == request('parent','') || $parentName == ucfirst(request('name',''))) selected="selected"
                                    @endif value="{{$parentName}}">{{$parentName}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="input_field">
                <label>Name:
                    <input id="stubName" type="text" name="name" value="{{request('name')}}" required="required">
                </label>
            </div>
            <div class="input_field">
                <input aria-label="checked all" type="checkbox"
                       {{ (!request()->has('dependency') || count(request('dependency')) === 0 ) ? 'checked' : ''  }} onclick="setAllCheckboxes('stubFiles',this)">
                check all<br/>
                <hr/>
                <div id="stubFiles" style="overflow:auto;height:450px;">
                    {!! $treeFilesCheckbox !!}
                </div>
            </div>
            <input class="button" type="submit" value="Generate">
        </form>
    @endif
</div>
<script defer src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script>
  function setAllCheckboxes(divId, sourceCheckbox) {
    let divElement = document.getElementById(divId);
    let inputElements = divElement.getElementsByTagName('input');
    for (let i = 0; i < inputElements.length; i++) {
      if (inputElements[i].type !== 'checkbox') {
        continue;
      }
      inputElements[i].checked = sourceCheckbox.checked;
    }
  }

  function UCFirstString(str) {
    let firstLetter = str.slice(0, 1);
    return firstLetter.toUpperCase() + str.substring(1);
  }

  function LCFirstString(str) {
    let firstLetter = str.slice(0, 1);
    return firstLetter.toLowerCase() + str.substring(1);
  }
  function ToSpaceCase(str) {
    return str.replace(/([a-z0-9])([A-Z])/g, '$1 $2').toLowerCase();
  }


  function ToSnakeCase(str) {
    return str
      .match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g)
      .map(x => x.toLowerCase())
      .join('_');
  }

  function replaceNameListFiles(stubName) {
    if (stubName === null || stubName === '') {
      stubName = 'x';
    }
    let todayDate = new Date();
    $('*[data-real-name]').each(function () {
      $(this).find('span').html($(this).attr('data-real-name').replace('.stub', '')
        .replace('%YEAR%', todayDate.getFullYear()).replace('%MONTH%', todayDate.getMonth() + 1).replace('%DAY%', todayDate.getDate()).replace('%TIMESTAMP%', Math.floor(todayDate.getTime() / 1000))
        .replace('%STUDLY_NAME%', UCFirstString(stubName)).replace('%LOWER_NAME%', LCFirstString(stubName)).replace('%SNAKE_NAME%', ToSnakeCase(stubName)).replace('%SPACE_NAME%', ToSpaceCase(stubName))
        .replace('TestTest', UCFirstString(stubName)).replace('test test', ToSpaceCase(stubName)).replace('testTest', LCFirstString(stubName)).replace('test_test', ToSnakeCase(stubName)),
      );
    });
  }

  window.addEventListener('load', (event) => {
    replaceNameListFiles($('#stubName').val());
    $('#stubName').on('keyup', function () {
      replaceNameListFiles($(this).val());
    });
  });
</script>
</body>
</html>
