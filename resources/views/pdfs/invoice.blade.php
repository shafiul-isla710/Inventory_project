<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <div class="max-w-md mx-auto text-center bg-white px-4 sm:px-8 py-10 rounded-xl shadow">
        <h1>Customer {{ $invoice->customer_id }}</h1>
        <p>Invoice</p>
        <table>
            <thead>
                <th>Name</th>
                <th>Roll</th>
                <th>Price</th>
            </thead>
            <tbody>
               
                <tr>
                    <td>Liyang</td>
                    <td>Kiyang</td>
                    <td>meyan</td>
                </tr>
                <tr>
                    <td>Liyang</td>
                    <td>Kiyang</td>
                    <td>meyan</td>
                </tr>
                
            </tbody>
        </table>
    </div>
    
</body>
</html>