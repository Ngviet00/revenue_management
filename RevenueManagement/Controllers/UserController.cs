using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using RevenueManagement.Models.Requests.User;
using RevenueManagement.Services;

namespace RevenueManagement.Controllers
{
    [Authorize]
    public class UserController : Controller
    {
        private readonly UserService userService;

        public UserController(UserService userService)
        {
            this.userService = userService;
        }
        public IActionResult Index()
        {
            return View();
        }

        [HttpGet]
        public IActionResult? Create()
        {
            return View();
        }

        [HttpGet]
        public IActionResult? Edit()
        {
            return null;
        }

        [HttpPatch]
        public IActionResult? Update()
        {
            return null;
        }

        [HttpDelete]
        public IActionResult? Delete()
        {
            return null;
        }

        [HttpGet]
        public IActionResult? ChangePassword()
        {
            return View();
        }

        [HttpPost, ValidateAntiForgeryToken]
        public async Task<IActionResult> ChangePassword(ChangePasswordRequest request)
        {
            if (ModelState.IsValid)
            {
                long userId = Convert.ToInt64(User.FindFirst("Id").Value);

                var user = await this.userService.GetById(userId);

                if (user is null)
                {
                    return RedirectToAction("Login", "Auth");
                }

                if (await this.userService.ChangePassword(user, request.NewPassword))
                {
                    ViewBag.Status = "success";
                    ViewBag.Message = "Cập nhật mật khẩu thành công!";
                }
                else
                {
                    ViewBag.Status = "failed";
                    ViewBag.Message = "Cập nhật mật khẩu thất bại!";
                }

                return RedirectToAction("ChangePassword", "User");
            }

            return View(request);
        }
    }
}
