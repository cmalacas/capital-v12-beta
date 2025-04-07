import { useState } from 'react';

import {FormGroup, Label, Input, Button, Modal, ModalHeader, ModalBody, ModalFooter} from 'reactstrap';

import { ToastContainer, Bounce } from 'react-toastify';

import ForgotPassword  from './ForgotPassword';
import Autservice from '@/components/Autservice';

export default function Login() {

  const [ email, setEmail ] = useState('')
  const [ password, setPassword ] = useState('');

  const handleSubmit = () => {

    const postData = { email , password, form: '2023' };

    Autservice.posts('/login', postData)
    .then( response => {
      if (response.user) {

        const user = response.user;

        const password_expiration = user.password_expiration;

        const current_time = response.current_time;

        if (true || password_expiration > current_time) {

            window.location.replace(response.location);    

        } else {

            Swal.fire(
                {
                    title: 'Password Expired',
                    html: 'Your password has expired. Please update your password',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Wave Password',
                    showDenyButton: true,    
                    customClass: {
                        confirmButton: 'btn btn-success text-nowrap',
                        cancelButton: 'btn btn-danger',                                    
                    }                            
                }
            )
            .then((result) => {
                if (result.isConfirmed) {

                    window.location.replace(response.location);   

                } else {

                    window.location.replace(response.location);   
                    // Authservice.posts('/wave-password')
                }
            })



        }

      }
    });

  }

  

  return (
    <div className="login-wrapper">
      <div className="pt-[100px]">
        <div className="login-container">
            <h1>Login to your account</h1>
            <p>Please enter your details below</p>
            <FormGroup>
                <Label>Email</Label>
                <Input type="text" placeholder="Email Address" value={email} onChange={ (e) => setEmail(e.target.value) } name="username" />
            </FormGroup>
            <FormGroup>
                <Label>Password</Label>
                <Input type="password" placeholder="Password" value={ password } onChange={ (e) => setPassword(e.target.value)  } name="password" />
            </FormGroup>
            <Button onClick={ handleSubmit } color="primary">Login</Button>
            <ForgotPassword />
        </div>
        </div>
        <ToastContainer
          position="top-right"
          autoClose={5000}
          hideProgressBar={false}
          newestOnTop={false}
          closeOnClick={false}
          rtl={false}
          pauseOnFocusLoss
          draggable
          pauseOnHover
          theme="light"
          transition={Bounce}
        />
    </div>
  )

}