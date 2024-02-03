using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.AspNetCore.Authentication;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using LoginRequest = RevenueManagement.Models.Requests.Auth.LoginRequest;
using System.Security.Claims;
using RevenueManagement.Services;

namespace RevenueManagement.Controllers
{
    [AllowAnonymous]
    public class AuthController : Controller
    {
        private readonly AuthService authService;

        public AuthController (AuthService authService)
        {
            this.authService = authService;
        }

        [HttpGet]
        public IActionResult Login()
        {
            if (HttpContext.User.Identity.IsAuthenticated)
            {
                return RedirectToAction("Index", "Home");
            }

            return View();
        }

        [HttpPost]
        public async Task<IActionResult> Login(LoginRequest loginRequest)
        {
            //validate
            if (!ModelState.IsValid)
            {
                return View(loginRequest);
            }

            //find user
            var user = await this.authService.Login(loginRequest);

            if (user is null)
            {
                ViewBag.ErrorMessage = "Tài khoản hoặc mật khẩu không chính xác!";
                return View(loginRequest);
            }

            //login success
            var claims = new List<Claim>
            {
                new Claim("Id", user.Id.ToString()),
                new Claim("Name", user.Name.ToString()),
                new Claim("UserName", user.Username.ToString()),
                new Claim("RoleId", user.RoldId.ToString())
            };
            var claimsIdentity = new ClaimsIdentity(claims, "Login");
            await HttpContext.SignInAsync(CookieAuthenticationDefaults.AuthenticationScheme, new ClaimsPrincipal(claimsIdentity));

            return RedirectToAction("Login", "Auth");
        }

        [HttpGet]
        public IActionResult? Register()
        {
            return View();
        }

        [HttpPost]
        public IActionResult? Register(LoginRequest loginRequest)
        {
            return null;
        }

        [HttpGet]
        public IActionResult? ForgetPassword()
        {
            return View("~/Views/Auth/ForgotPassword.cshtml"); ;
        }

        [HttpPost]
        public IActionResult? ForgetPassword(LoginRequest loginRequest)
        {
            return null;
        }

        [HttpPost, Authorize, ValidateAntiForgeryToken]
        public async Task<IActionResult> Logout()
        {
            await HttpContext.SignOutAsync(CookieAuthenticationDefaults.AuthenticationScheme);
            return RedirectToAction("Login", "Auth");
        }
    }
}
