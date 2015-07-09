
		
		<h3><?php echo $links ?></h3>
		
				<ul class="list-group">
				<?php foreach ($questions as $questions_item): ?>
				<li class="list-group-item">
					<?php echo validation_errors(); ?>
					<?php //echo form_open('questions/delete') ?>
					<form id="<?php echo $questions_item['QID']; ?>" method="post" accept-charset="utf-8">
					<input type="submit" class="btn btn-default" name="submit" value="删除测试题" onClick="deleteQuestion(<?php echo $questions_item['QID']; ?>)"/>
					<input type="submit" class="btn btn-default" name="submit" value="编辑测试题" onClick="editQuestion(<?php echo $questions_item['QID']; ?>)"/><br />
					<input type="hidden" name="QID" value="<?php echo $questions_item['QID']; ?>" />
					<div class="main">

						<?php echo '<strong>序号: </strong>'.$questions_item['QID'].'&nbsp;' ?><br/><br/>
						<?php echo '<strong>问题: </strong>'."<br />".$questions_item['QUESTION'] ?><br/><br/>
						<?php 
							echo '<strong>类型: </strong>';
							if ($questions_item['TYPE'] == 'JUDGE') {
								echo "判断题";
							}else if ($questions_item['TYPE'] == 'MULTICHOICE') {
								echo "多选题";
							}else
								echo "选择题";
							
						?><br/><br/>
						<?php 
							if ($questions_item['TYPE'] == 'CHOICE' || $questions_item['TYPE'] == 'MULTICHOICE') {
								echo '<strong>选项: </strong>'."<br/>";
								$token = strtok($questions_item['CHOICES'], "\\%%");
								echo "A. ".$token."<br/>";
								$token = strtok("\\%%");
								echo "B. ".$token."<br/>";
								$token = strtok("\\%%");
								echo "C. ".$token."<br/>";
								$token = strtok("\\%%");
								echo "D. ".$token."<br/><br/>";
							}
						?>
						<?php
						echo '<strong>答案: </strong>'/*.$questions_item['KEY']*/; 
						if($questions_item['KEY'] & 0x01)
							echo 'A ';
						if($questions_item['KEY'] & 0x02)
							echo 'B ';
						if($questions_item['KEY'] & 0x04)
							echo 'C ';
						if($questions_item['KEY'] & 0x08)
							echo 'D ';
						if($questions_item['KEY'] & 0x10)  
							echo 'T ';
						if($questions_item['KEY'] & 0x20)
							echo 'F ';
						 ?><br/><br/>
								 <?php
						echo '<strong>考察单元: </strong>'.$questions_item['EXAM_POINT'].'<br/>';
						echo '<strong>难度水平: </strong>'.$questions_item['LEVEL'].'<br/>';

						 ?>
						
					</div>
					</form>
					</li>
				<?php endforeach ?>
				
			</ul>
          </div>
        </div>
      </div>
    </div>
