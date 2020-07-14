<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
</head>
<body>
<form action="{{url('/regdo')}}" method="post" enctype="multipart/form-data">
    @csrf
    <table>
    <tr>
        <td>用户名</td>
        <td><input type="text" name="u_name"></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><input type="text" name="u_email"></td>
    </tr>
    <tr>
        <td>手机</td>
        <td><input type="text" nmae="u_phone"></td>
    </tr>
    <tr>
        <td>公司名称</td>
        <td><input type="text" name="g_name"></td>
    </tr>
    <tr>
        <td>公司地址</td>
        <td><input type="text" name="g_path"></td>
    </tr>
    <tr>
        <td>营业执照（照片）</td>
        <td><input type="file" name="u_img"></td>
    </tr>
    <tr>
        <td>密码</td>
        <td><input type="password" name="u_pwd"></td>
    </tr>
    <tr>
        <td>确认密码</td>
        <td><input type="password" name="u_pwds"></td>
    </tr>
    <tr>
        <td><input type="submit" value="注册"></td>
        <td></td>
    </tr>
    </table>
</form>
</body>
</html>