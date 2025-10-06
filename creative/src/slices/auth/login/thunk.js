//Include Both Helper File with needed methods
import { getFirebaseBackend } from "../../../helpers/firebase_helper";
import {
  postFakeLogin,
  postJwtLogin,
  postSocialLogin,
} from "../../../helpers/fakebackend_helper";

import { loginSuccess, logoutUserSuccess, apiError, reset_login_flag, loginBegin } from './reducer';
import { login as apiLogin } from '../../../helpers/api';
import { logout as apiLogout } from '../../../helpers/api';

// const fireBaseBackend = getFirebaseBackend();

export const loginUser = (user, history) => async (dispatch) => {

  try {
    let response;
    dispatch(loginBegin()) 
    if (process.env.REACT_APP_DEFAULTAUTH === "firebase") {
      let fireBaseBackend = getFirebaseBackend();
      response = fireBaseBackend.loginUser(
        user.email,
        user.password
      );
    } else if (process.env.REACT_APP_DEFAULTAUTH === "jwt") {
      response = postJwtLogin({
        email: user.email,
        password: user.password
      });

    } else if (process.env.REACT_APP_API_URL) {
      response = postFakeLogin({
        email: user.email,
        password: user.password,
      });
    }
    
    var data = await response;

    if (data) {
      sessionStorage.setItem("authUser", JSON.stringify(data));
      if (process.env.REACT_APP_DEFAULTAUTH === "fake") {
        var finallogin = JSON.stringify(data);
        finallogin = JSON.parse(finallogin)
        data = finallogin.data;
        if (finallogin.status === "success") {
          dispatch(loginSuccess(data));
          history('/dashboard')
        } else {
          dispatch(apiError(finallogin));
        }
      }else{
        dispatch(loginSuccess(data));
        history('/dashboard')
      }
    }
  } catch (error) {
    dispatch(apiError(error));
  }
};

export const logoutUser = () => async (dispatch) => {
  try {
    await apiLogout();
    sessionStorage.removeItem("authUser");
    sessionStorage.removeItem("token");
    dispatch(logoutUserSuccess(true));
  } catch (error) {
    dispatch(apiError(error.response?.data?.message || "Logout failed"));
  }
};

export const socialLogin = (type, history) => async (dispatch) => {
  try {
    let response;

    if (process.env.REACT_APP_DEFAULTAUTH === "firebase") {
      const fireBaseBackend = getFirebaseBackend();
      response = fireBaseBackend.socialLoginUser(type);
    }
    //  else {
      //   response = postSocialLogin(data);
      // }
      
      const socialdata = await response;
    if (socialdata) {
      sessionStorage.setItem("authUser", JSON.stringify(response));
      dispatch(loginSuccess(response));
      history('/dashboard')
    }

  } catch (error) {
    dispatch(apiError(error));
  }
};

export const resetLoginFlag = () => async (dispatch) =>{
  try {
    const response = dispatch(reset_login_flag());
    return response;
  } catch (error) {
    dispatch(apiError(error));
  }
};

export const loginUserReact = (user, history) => async (dispatch) => {
  try {
    dispatch(loginBegin());
    const response = await apiLogin(user.email, user.password, "/login-react");
    if (response.data && response.data.status) {
      // Use new structure: data contains token and user
      sessionStorage.setItem("token", response.data.data.token);
      sessionStorage.setItem("authUser", JSON.stringify(response.data.data.user));
      dispatch(loginSuccess(response.data.data.user));
      history('/dashboard');
    } else {
      dispatch(apiError(response.data.message || "Login failed"));
    }
  } catch (error) {
    dispatch(apiError(error.response?.data?.message || "Login failed"));
  }
};