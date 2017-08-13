<h2>KPI</h2>
<table width="100%" class="table table-bordered" style="border:1px solid #1a61d7;">
    <thead>
    <tr style="background: #7da0db;color:white;">
        <th title="Schedule Call"><b>Schedule Call</b></th>
        <th><b>Productive Memo</b></th>
        <th><b>Strike Rate</b></th>
        <th><b>TLSD</b></th>
        <th><b>LPSC</b></th>
        <th><b>Target (Raw)</b></th>
        <th><b>Order (Raw)</b></th>
        <th><b>Drop Size</b></th>
    </tr>
    </thead>
    <tbody>
    <tr style="background: #99b0d7;color:white;font-weight: bold;">
        <td><?php echo $schedule_call;?></td>
        <td><?php echo $productive_memo;?></td>
        <td><?php echo $strike_rate;?></td>
        <td><?php echo $tlsd;?></td>
        <td><?php echo $lpsc;?></td>
        <td><?php echo $target_case;?></td>
        <td><?php echo round($order_case,2);?></td>
        <td><?php echo $drop_size;?></td>
    </tr>
    </tbody>
</table>