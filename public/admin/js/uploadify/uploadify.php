<?php $session_name = session_name();
if (!isset($_POST[$session_name])) {
    exit;
} else {
    session_id($_POST[$session_name]);
    session_start();
}

$targetFolder = '/uploadfiles/'.$_SESSION["Users_ID"].'/'; // Relative to the root
if(@is_dir($_SERVER['DOCUMENT_ROOT'] .$targetFolder)===false){
    mkdir($_SERVER['DOCUMENT_ROOT'] .$targetFolder);
}
if (!empty($_FILES)) {
    $tempFile = $_FILES['Filedata']['tmp_name'];

    $fileTypes = [
        'image' => [
            'type' => 1,
            'ext' => ['gif', 'jpg', 'jpeg', 'png']
        ],
        'flash' => [
            'type' => 2,
            'ext'  => ['swf', 'flv']
        ],
        'media' => [
            'type' => 3,
            'ext'  => ['mp3','mp4']
        ],
        'flash' => [
            'type' => 4,
            'ext'  => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2','pem','pfx','cer']
        ]
    ];
    $fileParts = pathinfo($_FILES['Filedata']['name']);

    foreach($fileTypes as $k=>$v){
        if(in_array($fileParts['extension'],$v['ext'])){
            if(@is_dir($_SERVER['DOCUMENT_ROOT'] .$targetFolder.$k)===false){
                mkdir($_SERVER['DOCUMENT_ROOT'] .$targetFolder.$k);
            }
            $save_path = rtrim($targetFolder,'/') . '/' . $k . '/';
            $filename = dechex(time()) . dechex(rand(16, 255)) . '.' . $fileParts['extension'];
            $targetFile = $save_path . $filename;
            if (move_uploaded_file($tempFile,$_SERVER['DOCUMENT_ROOT'] . $targetFile) === false) {
                $Data=array(
                    "status"=>0,
                    "msg"=>'没有上传权限',
                );
            }else{
                if($v['type'] ==1 ){
                    //做缩略图
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/include/library/ImageThum.class.php';
                    $save_path = $_SERVER['DOCUMENT_ROOT'] . $save_path;
                    $file_path = $_SERVER['DOCUMENT_ROOT'] . $targetFile;
                    if (!file_exists($save_path . 'n0/')) {
                        mkdir($save_path . 'n0/');
                    }
                    if (!file_exists($save_path . 'n1/')) {
                        mkdir($save_path . 'n1/');
                    }
                    if (!file_exists($save_path . 'n2/')) {
                        mkdir($save_path . 'n2/');
                    }
                    if (!file_exists($save_path . 'n3/')) {
                        mkdir($save_path . 'n3/');
                    }
                    $thumImg = new imageThum();
                    $thumImg->littleImage($file_path, $save_path . 'n0/', 200);
                    $thumImg->littleImage($file_path, $save_path . 'n1/', 190);
                    $thumImg->littleImage($file_path, $save_path . 'n2/', 0, 350);
                    $thumImg->littleImage($file_path, $save_path . 'n3/', 100);
                }
                $Data=array(
                    "status"=>1,
                    "filename"=>$_FILES['Filedata']['name'],
                    "filesize"=>number_format($_FILES['Filedata']['size']/1024,2,".",""),
                    "filepath"=>$targetFile
                );
            }
            break;
        }
    }
    if(empty($Data)){
        $Data=array(
            "status"=>0,
            "msg"=>'无效的文件类型',
        );
    }
    echo json_encode($Data,JSON_UNESCAPED_UNICODE);
}
?>