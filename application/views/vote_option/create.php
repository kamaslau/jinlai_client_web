<style>

    /* 宽度在750像素以上的设备 */
    @media only screen and (min-width:751px)
    {

    }

    /* 宽度在960像素以上的设备 */
    @media only screen and (min-width:961px)
    {

    }

    /* 宽度在1280像素以上的设备 */
    @media only screen and (min-width:1281px)
    {

    }
</style>

<base href="<?php echo $this->media_root ?>">

<div id=content class=container>
    <div id=form-signup>
        <div class=full-screen-container>
            <a class=full-screen-close href="<?php echo base_url('vote/detail?id='.$item['vote_id']) ?>">
                <i class="far fa-times" aria-hidden=true></i>
            </a>

            <div class=full-screen-content>
                <h1 class=full-screen-title>报名参选</h1>

                <?php
                $attributes = array('class' => 'form-'.$this->class_name.'-create full-screen-form', 'role' => 'form');
                echo form_open_multipart('vote_option/create?vote_id='.$item['vote_id'], $attributes);
                ?>
                <fieldset>
                    <div class=input-group>
                        <label for=name>候选项名称</label>
                        <div>
                            <input name=name type=text placeholder="最多30个字" required value="<?php set_value('name') ?>">
                        </div>
                    </div>

                    <?php if ( ! empty($tags)): ?>
                    <div class=input-group>
                        <label for=tag_id>参选分类</label>
                        <div>
                            <select name=tag_id required>
                                <?php foreach($tags as $tag): ?>
                                    <option value="<?php echo $tag['tag_id'] ?>"><?php echo $tag['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <?php endif ?>

                    <div class=input-group>
                        <label for=url_image>形象图</label>
                        <div>
                            <?php
                            require_once(APPPATH. 'views/templates/file-uploader.php');
                            $name_to_upload = 'url_image';
                            generate_html($name_to_upload, 'vote_option', FALSE);
                            ?>
                        </div>
                    </div>

                    <div class=input-group>
                        <label for=description>描述</label>
                        <div>
                            <textarea name=description rows=3 placeholder="最多100个字"><?php set_value('description') ?></textarea>
                        </div>
                    </div>
                </fieldset>

                <button type=submit>报名</button>
                </form>

                <!--
                <hr>
                <p class=form-hint>报名后主办方会对被提名的候选项进行审核，审核通过后该候选项即可参选；每位用户仅可提名1个候选项，投票期间若不再关注相关公众号则视为弃权，已提名候选项及所有选票将立即失效、永久销毁。</p>
                -->
            </div>
        </div>
    </div>

</div>