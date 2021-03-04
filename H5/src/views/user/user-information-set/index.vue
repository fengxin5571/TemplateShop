<template>
  <div class="user_information">
    <van-cell-group>
      <van-cell title="头像" class="cell_middle">
        <van-uploader :afterRead="avatarAfterRead">
          <div class="user_avatar_upload">
            <img
              :src="avatar + '?x-oss-process=image/resize,m_fill,h_50,w_50'"
              alt="你的头像"
              v-if="avatar"
            >
            <van-icon name="camera_full" v-else></van-icon>
          </div>
        </van-uploader>
      </van-cell>

      <van-cell title="昵称" to="/user/information/setNickname" :value="nickName" isLink/>
      <van-cell title="性别" :value="genderText" @click="showSex = true" isLink/>
      <van-cell title="密码设置" to="/user/information/setPassword" isLink/>
      <van-cell title="手机号" to="/user/information/setMobile" :value="mobile" isLink></van-cell>
    </van-cell-group>

    <van-button size="large" class="user_quit" @click="loginOut">退出当前账户</van-button>

    <van-popup v-model="showSex" position="bottom">
      <van-picker
        showToolbar
        :columns="sexColumns"
        title="选择性别"
        @cancel="showSex = false"
        @confirm="onSexConfirm"
      />
    </van-popup>
  </div>
</template>

<script>
import { Uploader, Picker, Popup, Button } from 'vant';
import { removeLocalStorage ,setLocalStorage} from '@/utils/local-storage';
import { getLocalStorage } from '@/utils/local-storage';
import { authInfo, authLogout, authProfile,storageUpload } from '@/api/api';

export default {
  data() {
    return {
      sexColumns: [
        {
          values: ['保密', '男', '女'],
          defaultIndex: 0
        }
      ],
      showSex: false,
      avatar: '',
      nickName: '',
      gender: 0,
      mobile: ''
    };
  },

  computed: {
    genderText() {
      const text = ['保密', '男', '女'];
      return text[this.gender] || '';
    }
  },

  created() {
    this.getUserInfo();
  },

  methods: {
    avatarAfterRead(file) {
      console.log(file);
      let param = new FormData();
      param.append('file',file.file);
      storageUpload(param,{headers: {'Content-Type': 'multipart/form-data'}}).then(res=>{
          this.avatar=process.env.VUE_APP_BASE_API+res.data.data.pic;
          authProfile({avatar:res.data.data.pic}).then(res=>{
              localStorage.setItem('avatar', this.avatar);
              this.$dialog.alert({ message: res.data.errmsg }).then(() => {
              });
          });
      }).catch(err=>{
          this.$dialog.alert({ message: err.errmsg }).then(() => {

          });
      })
    },
    onSexConfirm(value, index) {
      this.showSex = false;
      authProfile({gender:index[0]}).then(res=>{
          this.gender=index[0];
          this.$dialog.alert({ message: '保存成功' }).then(() => {
              // this.$router.go(-1);
          });
      });
    },
    getUserInfo() {
      authInfo().then(res => {
        this.avatar = res.data.data.avatar;
        this.nickName = res.data.data.nickName;
        this.gender = res.data.data.gender;
        this.mobile = res.data.data.mobile;
      })
    },
    loginOut() {
      authLogout().then(res => {
        removeLocalStorage('Authorization')
        removeLocalStorage('avatar')
        removeLocalStorage('nickName')
        this.$router.push({ name: 'home' });
      });

    }
  },

  components: {
    [Button.name]: Button,
    [Uploader.name]: Uploader,
    [Picker.name]: Picker,
    [Popup.name]: Popup
  }
};
</script>


<style lang="scss" scoped>
.user_information {
  .user_avatar_upload {
    position: relative;
    width: 50px;
    height: 50px;
    border: 1px solid $border-color;
    img {
      max-width: 100%;
      max-height: 100%;
    }
    i {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 20px;
      color: $border-color;
    }
  }
  .user_quit {
    margin-top: 20px;
  }
}
</style>
