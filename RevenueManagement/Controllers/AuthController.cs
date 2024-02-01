using Microsoft.AspNetCore.Identity.Data;
using Microsoft.AspNetCore.Mvc;

namespace RevenueManagement.Controllers
{
    public class AuthController : Controller
    {
        [HttpGet]
        public IActionResult? Login()
        {
            return View("~/Views/Auth/Login.cshtml");
        }

        [HttpGet]
        public IActionResult? Register()
        {
            return View("~/Views/Auth/Register.cshtml");
        }

        [HttpGet]
        public IActionResult? ForgetPassword()
        {
            return View("~/Views/Auth/ForgotPassword.cshtml"); ;
        }

        [HttpPost]
        public IActionResult? Login(LoginRequest loginRequest)
        {
            //do something
            return null;
        }

        [HttpPost]
        public IActionResult? Logout()
        {
            Console.WriteLine("ss");
            Console.WriteLine("nguyen van a");
            return null;
        }
    }
}
