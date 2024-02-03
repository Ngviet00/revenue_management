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
        public IActionResult? ChangePassword(ChangePasswordRequest request)
        {
            long currentUserId = Convert.ToInt64(User.FindFirst("Id").Value);

            var check = userService.CheckPassword(request, currentUserId);

            if ()
            {

            }

            return View();
        }
    }
}
